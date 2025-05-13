<x-layouts.app :title="__('Dashboard')">
    <div class="flex flex-col items-center justify-center min-h-[70vh] text-center space-y-6 animate-fade-in">
        <div class="text-6xl"></div>
        <h1 class="text-4xl md:text-5xl font-extrabold text-indigo-600 dark:text-indigo-400">
            Selamat Datang, Robit! 👋
        </h1>
        <p class="text-lg md:text-xl text-gray-600 dark:text-gray-300 max-w-xl">
            Kamu sedang berada di dashboard administrator. Dari sini kamu bisa mengelola kategori, produk, dan semua yang berkaitan dengan aplikasi.
        </p>
    </div>

    <style>
        @keyframes fade-in {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        .animate-fade-in {
            animation: fade-in 1s ease-out;
        }
    </style>
</x-layouts.app>
