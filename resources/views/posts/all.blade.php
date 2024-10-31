<!DOCTYPE html>
<html lang="uz">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hamma Postlar - Blog Sayti</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="flex flex-col min-h-screen bg-gray-100">
    @include("layouts.profile_header")

    <main class="flex-grow container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-6">Hamma Postlar</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($allposts as $post)
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image" class="w-full h-48 object-cover rounded-lg mb-4">
                    <h2 class="text-xl font-bold mb-2">{{ $post->title }}</h2>
                    <p class="text-gray-700 mb-4">{{ Str::limit($post->description, 100) }}</p>
                    <p class="text-gray-700 mb-4">By <a href="{{ route('user.profile', $post->user->id) }}" class="text-indigo-600 hover:text-indigo-800">{{ $post->user->name }}</a></p>
                    <a href="{{ route('posts.show', $post) }}" class="text-indigo-600 hover:text-indigo-800">O'qish</a>
                </div>
            @endforeach
        </div>
    </main>

    @include("layouts.footer")
</body>

</html>
