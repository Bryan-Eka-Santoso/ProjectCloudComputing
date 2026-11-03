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
    <style>body { font-family: 'Nunito', sans-serif; }</style>
</head>
<body class="bg-abu-50 text-slate-800">
    <div class="min-h-screen flex flex-col">
        @hasSection('nav')
            <header class="bg-white border-b border-abu-300 px-6 py-4 flex items-center justify-between">
                @yield('nav')
            </header>
        @endif

        @if (session('info'))
            <div class="bg-biru/10 text-biru font-semibold text-center py-3 px-4">
                {{ session('info') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="bg-merah/10 text-merah font-semibold text-center py-3 px-4">
                {{ $errors->first() }}
            </div>
        @endif

        <main class="flex-1 px-6 py-8 max-w-5xl w-full mx-auto">
            @yield('content')
        </main>
    </div>
</body>
</html>
