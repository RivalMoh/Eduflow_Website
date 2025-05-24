<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    /** @use HasFactory<\Database\Factories\AttachmentFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'postid',
        'replyid',
        'file_name',
        'file_path',
        'file_type',
        'file_size',
    ];

    /**
     * Get the forum post that owns the attachment.
     */
    public function forumPost()
    {
        return $this->belongsTo(ForumPost::class, 'postid', 'postid');
    }

    /**
     * Get the forum reply that owns the attachment.
     */
    public function forumReply()
    {
        return $this->belongsTo(ForumReply::class, 'replyid', 'replyid');
    }
}
