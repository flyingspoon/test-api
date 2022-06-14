<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Albums extends Model
{
    use HasFactory;

    public function artist() {
        // Artist that belongs to album
        return $this->hasOne(
            Artists::class,
            'id',
            'artist'
        );
    }

    public function music($pagination=true) {
        // All music belonging to album
        return true;
    }
}
