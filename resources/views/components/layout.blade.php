<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
    content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Personal Finance Manager</title>
    <link rel="preconnect"href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link 
        href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wgt@400;500;600&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-black text-white font-hanken-grotesk pb-20">
     <div class="px-10">
        <nav class="flex justify-between items-center py-4 border-b border-white/10">
            <div>
                <!-- <a href="">
                    <img src="{{ Vite::asset('resources/images/logo.svg') }}" alt="">
                </a> -->
                <h2><strong>FinanceMe</strong></h2>
            </div>

            @auth
            <div class="space-x-6 font-bold flex">
                <a>Dashboard</a>
                <a>Transactions</a>
                <a>History</a>
            </div>
            <div class="space-x-6 font-bold flex">
                
                <form method="POST" action="/logout">
                    @csrf
                    @method('DELETE')

                    <button>Log Out</button>
                </form>

            </div>

            @endauth

            @guest
            <div class="space-x-6 font-bold">
                <a href="/register">Sign Up</a>
                <a href="/login">Log In</a>
            </div>
            @endguest
        </nav>

        <main class="mt-10 max-w-[926px] mx-auto">
            {{ $slot }}
        </main>
     </div>
</body>
</html>