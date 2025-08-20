<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Pack extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];
    protected $appends = ['file_name'];
    protected $hidden = ['file'];


     /**
     * Get the user that owns the Melody
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class)->with('socialmedia');
    }


    /**
     * Get all of the genrese for the Melody
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function packGenrese()
    {
        return $this->belongsToMany(Genres::class, 'pack_genres', 'pack_id', 'genre_id');
    }

    /**
     * Get All Demos for the Pack
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function melodies(): HasMany
    {
        return $this->hasMany(Melody::class, 'pack_id');
    }

    /**
     * Get One Demos for the Pack Preview
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function melodiesFirst(): HasOne
    {
        return $this->hasOne(Melody::class, 'pack_id');
    }

    /**
     * Accessor for dynamically getting the file name from the file path.
     *
     * @return string
     */
    public function getFileNameAttribute()
    {   
        // Check if the 'file' attribute is set and not empty
        if (!empty($this->attributes['file'])) {
            // Extract the file name from the file path
            return basename($this->attributes['file']);
        }

        return ''; // Return an empty string if 'file' is not set
    }

    /**
     * Get All orders for the Melody
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'pack_id');
    }



    // accessor of avater attribute
    public function getFileAttribute($value)
    {
        // Check if $value contains the substring 'google'
        if (strpos($value, 'https://') !== false) {
            return $value; // Return original $value if it contains 'google'
        } else {
            return $value ? 'storage/' . $value : null; // Otherwise, prepend 'storage/' and return
        }
    }
}
