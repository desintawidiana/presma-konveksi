
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Presma Operations</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gray-100 text-gray-800">
    <header class="bg-white shadow-sm">
        <div class="mx-auto flex max-w-6xl items-center justify-between px-6 py-4">
            <h1 class="text-lg font-bold">Presma Operations</h1>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button
                    type="submit"
                    class="rounded-lg bg-red-700 px-4 py-2 text-sm font-medium text-white hover:bg-red-800"
                >
                    Keluar
                </button>
            </form>
        </div>
    </header>

    <main class="mx-auto max-w-6xl px-6 py-10">
        <div class="rounded-xl bg-white p-6 shadow-sm">
            <p class="text-sm text-gray-500">Dashboard</p>

            <h2 class="mt-2 text-2xl font-bold">
                Selamat datang, {{ auth()->user()->nama }}!
            </h2>

            <p class="mt-2 text-gray-600">
                Kamu berhasil masuk ke sistem Presma Konveksi.
            </p>

            <div class="mt-6 rounded-lg bg-gray-50 p-4">
                <p>
                    <span class="font-medium">Username:</span>
                    {{ auth()->user()->username }}
                </p>

                <p class="mt-2">
                    <span class="font-medium">Role:</span>
                    {{ auth()->user()->peran }}
                </p>
            </div>
        </div>
    </main>
</body>
</html>