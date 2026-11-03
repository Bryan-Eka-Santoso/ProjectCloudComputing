<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Ceria Otak' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Nunito', 'sans-serif'] },
                    colors: {
                        biru: '#2F6FA8',
                        oranye: '#E8793D',
                        merah: '#D1483A',
                        abu: { 50: '#F7F8FA', 100: '#F4F5F7', 200: '#F0F1F3', 300: '#E6E8EC', 400: '#9AA3AE' },
                    },
                },
            },
        };
    </script>
    <style>
        body { font-family: 'Nunito', sans-serif; }
        .tap-target { min-height: 64px; }
    </style>
</head>
<body class="bg-white text-slate-800 text-lg">
    <div class="max-w-md mx-auto min-h-screen flex flex-col">
        @if (session('info'))
            <div class="bg-biru/10 text-biru font-semibold text-center py-3 px-4">
                {{ session('info') }}
            </div>
        @endif

        <main class="flex-1 px-5 pb-28 pt-4">
            @yield('content')
        </main>

        @hasSection('bottom-nav')
            <nav class="fixed bottom-0 inset-x-0 max-w-md mx-auto bg-abu-100 border-t border-abu-300 flex justify-around py-3">
                @yield('bottom-nav')
            </nav>
        @endif
    </div>
</body>
</html>
