<?php

namespace App\Livewire\Admin;

use App\Models\Comment;
use App\Models\CommentLike;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class CommentComponent extends Component
{
    use WithPagination;

    public $post;
    public $replyingTo = null;
    public $replyContent = '';
    public $perPage = 5;
    protected $paginationTheme = 'bootstrap';

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

        $parentComment = Comment::find($parentId);
        if (!$parentComment) return;

        Comment::create([
            'post_id' => $parentComment->post_id,
            'user_id' => Auth::id(),
            'parent_id' => $parentId,
            'content' => $this->replyContent
        ]);

        $this->replyingTo = null;
        $this->replyContent = '';
        $this->resetPage(); // Reiniciar la paginación después de una respuesta
    }

    public function deleteComment($commentId)
    {
        $comment = Comment::find($commentId);

        if (!$comment) return;

        if ($comment->user_id === Auth::id()) {
            $comment->delete();
            session()->flash('message', 'Comentario eliminado correctamente.');
        }
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
        return Comment::count();
    }


    public function render()
    {
        $comments = Comment::whereNull('parent_id')
            ->with([
                'replies' => function ($query) {
                    $query->orderBy('created_at', 'desc');
                },
                'likes' => function ($query) {
                    $query->where('user_id', Auth::id());
                }
            ])
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage); // Se paginan los comentarios principales

        return view('livewire.admin.comment-component', compact('comments'))
            ->extends('admin.layouts.app');
    }
}
