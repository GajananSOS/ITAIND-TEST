<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['comment', 'article_id', 'comment_by'];


    public function commented_by()
    {
        return $this->belongsTo(User::class, 'comment_by');
    }
}
