<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CommentRequest;

class CommentController extends Controller
{
    public function index($postId)
    {
        $post = Post::findOrFail($postId);
        return view('posts.show', compact('post'));
    }

    public function store(CommentRequest $request, $postId)
    {
        $post = Post::findOrFail($postId);
    
        // Izoh qo'shish
        $post->comments()->create([
            "content" => $request->comment,
            "user_id" => Auth::id(),
        ]);
    
        return redirect()->route('posts.show', $postId)->with('success', 'Izoh muvaffaqiyatli qo\'shildi.');
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);

        // O'chirish uchun faqat izoh egasi ruxsat berilgan bo'lishi kerak
        if ($comment->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Siz bu izohni o\'chira olmaysiz.');
        }

        $comment->delete();
        return redirect()->back()->with('success', 'Izoh muvaffaqiyatli o\'chirildi.');
    }
}
