<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Posts - Blog Site</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="flex flex-col min-h-screen bg-gray-100">

    @include("layouts.header");


    <!-- Main content -->
    <main class="flex-grow container mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-md p-8 text-center">
            <h2 class="text-2xl font-bold mb-4">Welcome to BlogSite!</h2>
            <p class="text-lg text-gray-500 mb-8">Please
                <a class="text-indigo-500 hover:text-indigo-700 underline" href="{{ route('login') }}">Log in</a>
                or
                <a class="text-indigo-500 hover:text-indigo-700 underline" href="{{ route('register') }}">Sign up</a>
                to view all posts.
            </p>
        </div>
    </main>

    @include("layouts.footer");


</body>

</html>