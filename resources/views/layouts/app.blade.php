<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CareerCON</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen">
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('dashboard') }}" class="text-xl font-bold">CareerCON</a>
                </div>
                <div class="flex items-center">
                    @auth
                        <span class="mr-4">Welcome, {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</span>
                        <form action="{{ route('auth.destroy') }}" method="POST">
                            @csrf
                            <button type="submit" class="text-red-500 hover:text-red-700">Logout</button>
                        </form>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="bg-white shadow-lg mt-8">
        <div class="max-w-7xl mx-auto py-4 px-4">
            <p class="text-center text-gray-600">&copy; {{ date('Y') }} CareerCON. All rights reserved.</p>
        </div>
    </footer>
</body>
</html> 