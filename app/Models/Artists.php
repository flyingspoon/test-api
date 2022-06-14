<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artists extends Model
{
    use HasFactory;

    public function albums($pagination=true) {
        // All artist albums in paginated view
        return true;
    }

    public function latest($total=1, $pagination=false) {
        // Latest song releases
        return true;
    }

    public function recommendations() {
        // Find artists by similar genre?
        return true;
    }
}
