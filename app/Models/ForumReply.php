<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumReply extends Model
{
    /** @use HasFactory<\Database\Factories\ForumReplyFactory> */
    use HasFactory;

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'replyid';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'postid',
        'user_id',
        'content',
    ];

    /**
     * Get the user that owns the forum reply.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Get the forum post that owns the forum reply.
     */
    public function post()
    {
        return $this->belongsTo(ForumPost::class, 'postid', 'postid');
    }

    /**
     * Get the attachments for the forum reply.
     */
    public function attachments()
    {
        return $this->hasMany(Attachment::class, 'replyid', 'replyid');
    }
}
