<!-- resources/views/components/layout/app-layout.blade.php -->
@props(['type' => 'top'])

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hacker News Clone</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <header class="mb-6">
            <h1 class="text-2xl font-bold text-orange-600">Hacker News Clone</h1>
            <nav class="flex space-x-4 mt-4">
                <a href="{{ route('stories.index', 'top') }}" 
                   class="{{ $type === 'top' ? 'font-bold text-orange-600' : 'text-gray-600' }}">Top</a>
                <a href="{{ route('stories.index', 'new') }}" 
                   class="{{ $type === 'new' ? 'font-bold text-orange-600' : 'text-gray-600' }}">New</a>
                <a href="{{ route('stories.index', 'best') }}" 
                   class="{{ $type === 'best' ? 'font-bold text-orange-600' : 'text-gray-600' }}">Best</a>
            </nav>
        </header>

        <main>
            {{ $slot }}
        </main>
    </div>
</body>
</html>