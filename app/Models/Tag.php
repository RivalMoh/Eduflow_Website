<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    /** @use HasFactory<\Database\Factories\TagFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'color',
    ];

    /**
     * Get all of the notes that are assigned this tag.
     */
    public function notes()
    {
        return $this->morphedByMany(Note::class, 'taggable');
    }

    /**
     * Get all of the tasks that are assigned this tag.
     */
    public function tasks()
    {
        return $this->morphedByMany(Task::class, 'taggable');
    }

    /**
     * Get all of the forum posts that are assigned this tag.
     */
    public function forumPosts()
    {
        return $this->morphedByMany(ForumPost::class, 'taggable');
    }
}
