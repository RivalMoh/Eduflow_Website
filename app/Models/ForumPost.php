<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumPost extends Model
{
    /** @use HasFactory<\Database\Factories\ForumPostFactory> */
    use HasFactory;

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'postid';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'title',
        'content',
        'views',
    ];

    /**
     * Get the user that owns the forum post.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Get the replies for the forum post.
     */
    public function replies()
    {
        return $this->hasMany(ForumReply::class, 'postid', 'postid');
    }

    /**
     * Get the attachments for the forum post.
     */
    public function attachments()
    {
        return $this->hasMany(Attachment::class, 'postid', 'postid');
    }

    /**
     * Get all of the tags for the forum post.
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
}
