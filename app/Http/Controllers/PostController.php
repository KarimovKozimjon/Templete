<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StorePostRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdatePostRequest;

class PostController extends Controller
{
    public function createPostForm()
    {
        return view("posts.create");
    }

    public function createPost(StorePostRequest $request)
    {
        // Foydalanuvchini tekshirish
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Iltimos, tizimga kiring.');
        }

        // Rasmni yuklash
        $imagePath = $request->file('image')->store('images', 'public');

        // Yangi post yaratish
        Post::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'image' => $imagePath,
            'user_id' => Auth::id()
        ]);

        return redirect()->route('profile.show')->with('success', 'Post yaratildi!');
    }

    public function showProfile()
    {
        $myposts = Post::where('user_id', Auth::id())->get(); // Faqat o'z postlarini olish
        return view('profile.show', compact('myposts'));
    }

    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        // Postni yangilash
        $post->title = $request->input('title');
        $post->description = $request->input('description');

        // Agar yangi rasm yuklangan bo'lsa, uni saqlash
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $post->image = $imagePath;
        }

        $post->save();

        return redirect()->route('posts.show', $post)->with('success', 'Post muvaffaqiyatli yangilandi.');
    }

    public function destroy(Post $post)
    {
        // Check if the post has an image and delete it if it exists
        if ($post->image) {
            Storage::delete($post->image);
        }

        // Delete the post
        $post->delete();

        return redirect()->route('profile.show')->with('success', 'Post muvaffaqiyatli o\'chirildi.');
    }


    public function index()
    {
        $allposts = Post::with('user')->get(); // Barcha postlarni olish
        return view('posts.all', compact('allposts'));
    }
}
