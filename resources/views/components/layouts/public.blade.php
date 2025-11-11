<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-900">
        <nav class="border-b border-zinc-200 bg-white dark:border-zinc-800 dark:bg-zinc-900">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-between">
                    <div class="flex items-center gap-8">
                        <a href="{{ route('home') }}" class="flex items-center space-x-2">
                            <x-app-logo />
                        </a>
                        <div class="hidden gap-4 md:flex">
                            <a href="{{ route('home') }}" class="text-sm font-medium text-zinc-900 hover:text-zinc-700 dark:text-zinc-100 dark:hover:text-zinc-300">Home</a>
                            <a href="{{ route('blog.index') }}" class="text-sm font-medium text-zinc-900 hover:text-zinc-700 dark:text-zinc-100 dark:hover:text-zinc-300">Blog</a>
                        </div>
                    </div>
                    <div>
                        @auth
                            <a href="{{ route('dashboard') }}" class="text-sm font-medium text-zinc-900 hover:text-zinc-700 dark:text-zinc-100 dark:hover:text-zinc-300">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-medium text-zinc-900 hover:text-zinc-700 dark:text-zinc-100 dark:hover:text-zinc-300">Login</a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        {{ $slot }}

        <footer class="border-t border-zinc-200 bg-white py-8 dark:border-zinc-800 dark:bg-zinc-900">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <p class="text-center text-sm text-zinc-600 dark:text-zinc-400">
                    &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                </p>
            </div>
        </footer>

        @fluxScripts
    </body>
</html>
