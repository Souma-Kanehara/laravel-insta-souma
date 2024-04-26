<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory, SoftDeletes;

    # Use this method to get the owner of the comment
    public function user() {
        return $this->belongsTo(User::class)->withTrashed();
    }
}
