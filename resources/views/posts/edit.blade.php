<!DOCTYPE html>
<html lang="uz">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post - Blog Site</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="flex flex-col min-h-screen bg-gray-100">
    @include("layouts.profile_header")

    <!-- Asosiy kontent -->
    <main class="flex-grow container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-md">
            <h1 class="text-2xl font-bold mb-6">Postni Tahrirlash</h1>
            <a href="{{ route('posts.show', $post) }}" class="text-indigo-600 hover:text-indigo-800 underline mb-4">Orqaga</a>
            <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700">Sarlavha</label>
                    <input type="text" id="title" name="title" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                        value="{{ $post->title }}" autofocus>
                </div>
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700">Tavsif</label>
                    <textarea id="description" name="description" rows="4" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 resize-none"
                        spellcheck="false">{{ $post->description }}</textarea>
                </div>
                <div class="mb-4">
                    <label for="image" class="block text-sm font-medium text-gray-700">Rasm</label>
                    <input type="file" id="image" name="image" accept="image/*"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <p class="mt-2 text-sm text-gray-500">Joriy rasm: {{ asset('storage/' . $post->image) }}</p>
                </div>
                <button type="submit"
                    class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Postni Yangilash</button>
            </form>
        </div>
    </main>

    @include("layouts.footer")
</body>

</html>