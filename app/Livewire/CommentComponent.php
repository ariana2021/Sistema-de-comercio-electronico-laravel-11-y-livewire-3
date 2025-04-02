<?php

namespace App\Livewire;

use App\Models\Comment;
use App\Models\CommentLike;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CommentComponent extends Component
{
    public $post;
    public $newComment = '';
    public $replyingTo = null;
    public $replyContent = '';

    public function postComment()
    {
        $this->validate([
            'newComment' => 'required|string|min:3|max:1000'
        ]);

        Comment::create([
            'post_id' => $this->post->id,
            'user_id' => Auth::id(),
            'content' => $this->newComment
        ]);

        $this->newComment = '';
    }

    public function userLiked($commentId)
    {
        return Comment::find($commentId)->likes->contains('user_id', auth()->id());
    }

    public function setReplyingTo($commentId)
    {
        $this->replyingTo = $commentId;
        $this->replyContent = '';
    }

    public function postReply($parentId)
    {
        $this->validate([
            'replyContent' => 'required|string|min:3|max:1000'
        ]);

        Comment::create([
            'post_id' => $this->post->id,
            'user_id' => Auth::id(),
            'parent_id' => $parentId,
            'content' => $this->replyContent
        ]);

        $this->replyingTo = null;
        $this->replyContent = '';
    }

    public function likeComment($commentId)
    {
        $comment = Comment::find($commentId);
        if (!$comment) return;

        $existingLike = CommentLike::where('comment_id', $commentId)
            ->where('user_id', Auth::id())
            ->first();

        if ($existingLike) {
            $existingLike->delete();
            $comment->decrement('likes_count');
        } else {
            CommentLike::create([
                'comment_id' => $commentId,
                'user_id' => Auth::id()
            ]);
            $comment->increment('likes_count');
        }
    }

    public function getTotalCommentsProperty()
    {
        return Comment::where('post_id', $this->post->id)->count();
    }


    public function render()
    {
        return view('livewire.comment-component', [
            'comments' => Comment::where('post_id', $this->post->id)
                ->whereNull('parent_id')
                ->with([
                    'replies' => function ($query) {
                        $query->orderBy('created_at', 'asc');
                    },
                    'likes' => function ($query) {
                        $query->where('user_id', Auth::id());
                    }
                ])
                ->orderBy('created_at', 'asc')
                ->get()
        ]);
    }
}
