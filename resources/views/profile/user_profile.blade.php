<!DOCTYPE html>
<html lang="uz">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $user->name }} - Profil</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="flex flex-col min-h-screen bg-gray-100">
    @include("layouts.profile_header")

    <main class="flex-grow container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                <div class="flex flex-col sm:flex-row items-center mb-4">
                    <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('default-avatar.png') }}" alt="User Avatar"
                        class="w-20 h-20 rounded-full mr-4 mb-4 sm:mb-0">
                    <div class="text-center sm:text-left">
                        <h1 class="text-2xl font-bold">{{ $user->name }}</h1>
                        <p class="text-gray-600">{{ $user->email }}</p>

                    </div>
                    <div class="mt-4 sm:mt-0 sm:ml-auto">
                        @if(Auth::user()->isFollowing($user))
                        <form action="{{ route('user.unfollow', $user) }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-red-600 text-white py-2 px-4 rounded-md hover:bg-red-700">Unfollow</button>
                        </form>
                        @else
                        <form action="{{ route('user.follow', $user) }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700">Follow</button>
                        </form>
                        @endif
                    </div>

                </div>

                <div class="flex flex-wrap justify-center sm:justify-start space-x-4">
                    <span class="font-semibold">{{ $followersCount }} Followers</span>
                    <span class="font-semibold">{{ $followingCount }} Following</span>
                    <span class="font-semibold">{{ $posts->count() }} Posts</span>
                </div>

            </div>

            <h2 class="text-2xl font-bold mb-4">User's Posts</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($posts as $post)
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image"
                        class="w-full h-48 object-cover rounded-lg mb-4">
                    <h3 class="text-xl font-bold mb-2">{{ $post->title }}</h3>
                    <p class="text-gray-700 mb-4">{{ Str::limit($post->description, 100) }}</p>
                    <a href="{{ route('posts.show', $post) }}" class="text-indigo-600 hover:text-indigo-800">O'qish</a>
                </div>
                @endforeach
            </div>
        </div>
    </main>

    @include("layouts.footer")
</body>

</html>