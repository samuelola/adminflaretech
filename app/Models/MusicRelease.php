<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MusicRelease extends Model
{
    protected $guarded = [];
    protected $casts = ['meta' => 'array'];
    protected $table ='music_releases';

    public function artworks() {
         return $this->hasMany(Artwork::class,'music_release_id');
     }
     
    public function audioFiles() { 
        return $this->hasMany(AudioFile::class,'music_release_id'); 
    }
    public function tracks() {
         return $this->hasMany(Track::class,'music_release_id');
     }
    public function outlets() { 
        return $this->hasMany(Outlet::class,'music_release_id'); 
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
<<<<<<< HEAD

    public function verification()
    {
        return $this->hasOne(Verification::class,'music_release_id');
    }
=======
>>>>>>> b27e3ab4af188d781835f7d5dfe90a47a625a22f
}
