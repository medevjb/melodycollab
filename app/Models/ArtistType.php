<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ArtistType extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded =[];


    /**
     * Relation Between artist type and MelodyArtistType
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     * @see App\Models\MelodyArtistType
     */
    public function melodies()
    {
        return $this->hasMany(MelodyArtistType::class, 'artist_type_id');
    }
}

