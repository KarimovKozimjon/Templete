<!DOCTYPE html>
<html lang="uz">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ Auth::user()->name }} - Profil</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="flex flex-col min-h-screen bg-gray-100">
    @include('layouts.profile_header')

    <!-- Asosiy kontent -->
    <main class="flex-grow container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                <div class="flex flex-col sm:flex-row items-center mb-4">
                    <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : asset('default-avatar.png') }}" alt="Foydalanuvchi Avatar"
                        class="w-20 h-20 rounded-full mr-4 mb-4 sm:mb-0">
                    <div class="text-center sm:text-left">
                        <h1 class="text-2xl font-bold">{{ Auth::user()->name }}</h1>
                        <p class="text-gray-600">{{ Auth::user()->email }}</p>
                    </div>

                    <!-- Profilni Tahrirlash Tugmasi -->
                    <div class="mt-4 sm:mt-0 sm:ml-auto">
                        <a href="{{ route('profile.edit') }}"
                            class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">
                            Profilni Tahrirlash
                        </a>
                    </div>
                </div>

                <div class="flex flex-wrap justify-center sm:justify-start space-x-4">
                    <span class="font-semibold">{{ Auth::user()->followersCount() }} Followers</span>
                    <span class="font-semibold">{{ Auth::user()->followingCount() }} Following</span>

                    <span class="font-semibold">{{ $myposts->count() }} Posts</span>
                </div>
            </div>

            <h2 class="text-2xl font-bold mb-4">Mening Postlarim</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach ($myposts as $post)
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <img src="{{ asset('storage/' . $post->image) }}" alt="Post Rasm"
                        class="w-full h-48 object-cover rounded-lg mb-4">
                    <h3 class="text-xl font-bold mb-2">{{ $post->title }}</h3>
                    <p class="text-gray-700 mb-4">{{ Str::limit($post->description, 100) }}</p>
                    <div class="flex space-x-2">
                        <a href="{{ route('posts.show', $post) }}" class="text-indigo-600 hover:text-indigo-800">Batafsil</a>
                        <a href="{{ route('posts.edit', $post) }}" class="text-green-600 hover:text-green-800">Tahrirlash</a>
                        <form action="{{ route('posts.destroy', $post) }}" method="POST" onsubmit="return confirm('Ushbu postni o\'chirishni xohlayotganingizga ishonchingiz komilmi?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800">O'chirish</button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </main>

    @include('layouts.footer')
</body>

</html>