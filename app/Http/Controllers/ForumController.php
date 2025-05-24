<?php

namespace App\Http\Controllers;

use App\Models\ForumPost;
use App\Models\ForumReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForumController extends Controller
{
    /**
     * Store a new forum post.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storePost(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'media' => 'nullable|file|max:10240', // 10MB max
        ]);

        $post = new ForumPost();
        $post->user_id = auth()->id();
        $post->title = $validated['title'];
        $post->content = $validated['content'];

        // Handle file upload
        if ($request->hasFile('media') && $request->file('media')->isValid()) {
            $file = $request->file('media');
            $path = $file->store('forum-media', 'public');
            
            $post->media_path = $path;
            $post->media_name = $file->getClientOriginalName();
            $post->media_type = $this->getMediaType($file);
        }

        $post->save();

        return redirect()->back()->with('success', 'Post created successfully!');
    }

    /**
     * Get the media type based on file mime type
     */
    private function getMediaType($file)
    {
        $mimeType = $file->getMimeType();
        
        if (str_starts_with($mimeType, 'image/')) {
            return 'image';
        }
        
        if (in_array($file->getClientOriginalExtension(), ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'txt'])) {
            return 'document';
        }
        
        return 'file';
    }

    /**
     * Store a new reply to a forum post.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $postId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeReply(Request $request, $postId)
    {
        $validated = $request->validate([
            'content' => 'required|string',
        ]);

        $reply = new ForumReply();
        $reply->postid = $postId;
        $reply->user_id = Auth::id();
        $reply->content = $validated['content'];
        $reply->save();

        return redirect()->back()->with('success', 'Reply added successfully!');
    }

    /**
     * Delete a forum post.
     *
     * @param  int  $postId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deletePost($postId)
    {
        $post = ForumPost::findOrFail($postId);
        
        // Check if the authenticated user is the owner of the post
        if ($post->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'You are not authorized to delete this post.');
        }

        $post->delete();

        return redirect()->route('home')->with('success', 'Post deleted successfully!');
    }
}
