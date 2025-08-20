<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Melody extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];
    protected $appends = ['file_name'];

    /**
     * Get the user that owns the Melody
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function pack()
    {
        return $this->belongsTo(Pack::class);
    }

    /**
     * Get all of the genres for the Melody.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function melodyGenres(): BelongsToMany
    {
        return $this->belongsToMany(Genres::class, 'melody_genres', 'melody_id', 'genre_id');
    }

/**
 * Get all of the Instruments for the Melody.
 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
 */
    public function melodyInstruments(): BelongsToMany
    {
        return $this->belongsToMany(Instrument::class, 'melody_instruments', 'melody_id', 'instrument_id');
    }

/**
 * Get all of the Artist Types for the Melody.
 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
 */
    public function melodyArtistTypes(): BelongsToMany
    {
        return $this->belongsToMany(ArtistType::class, 'melody_artist_types', 'melody_id', 'artist_type_id');
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

    // accessor of avatar attribute
    public function getFileAttribute($value)
    {
        if (strpos($value, 'https://') !== false) {
            return $value;
        } else {
            // Check if 'storage/' is already present
            return $value && strpos($value, 'storage/') === false ? 'storage/' . $value : $value;
        }
    }

}
