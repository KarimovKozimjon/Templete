<!DOCTYPE html>
<html lang="uz">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $post->title }} - Blog Site</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="flex flex-col min-h-screen bg-gray-100">
    @include("layouts.profile_header")

    <main class="flex-grow container mx-auto px-4 py-8">
        <article class="max-w-3xl mx-auto bg-white p-8 rounded-lg shadow-md">
            <h1 class="text-3xl font-bold mb-4">{{ $post->title }}</h1>
            <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image" class="w-full h-64 object-cover rounded-lg mb-4">
            <p class="text-gray-700 mb-6">{{ $post->description }}</p>
 
            <div class="flex justify-end space-x-2">
                <a href="{{ route('posts.edit', $post) }}" class="text-indigo-600 hover:text-indigo-800">Tahrirlash</a>
                <form action="{{ route('posts.destroy', $post) }}" method="POST" onsubmit="return confirm('Ushbu postni o\'chirishni xohlayotganingizga ishonchingiz komilmi?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-500 hover:text-red-700">O'chirish</button>
                </form>
            </div>

            <h2 class="text-2xl font-bold mb-4">Izohlar</h2>
            <div class="space-y-4 mb-6">
                @if($post->comments && $post->comments->count())
                    @foreach($post->comments as $comment)
                        <div class="bg-gray-50 p-4 rounded-lg flex justify-between">
                            <div>
                                <p class="font-semibold">{{ $comment->user->name }}</p>
                                <p class="text-gray-700">{{ $comment->content }}</p>
                            </div>
                            <div class="flex space-x-2">
                                <form action="{{ route('comments.destroy', $comment) }}" method="POST" onsubmit="return confirm('Izohni o\'chirishni xohlayotganingizga ishonchingiz komilmi?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700">O'chirish</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-gray-600">Izohlar mavjud emas.</p>
                @endif
            </div>

            <form action="{{ route('comments.store', $post->id) }}" method="POST">
                @csrf
                <h3 class="text-xl font-bold mb-2">Izoh qo'shish</h3>
                <textarea id="comment" name="comment" rows="3" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                    placeholder="Izohingizni yozing..."></textarea>
                <button type="submit"
                    class="mt-2 bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Izohni
                    yuborish</button>
            </form>
        </article>
    </main>

    @include("layouts.footer")
</body>

</html>
