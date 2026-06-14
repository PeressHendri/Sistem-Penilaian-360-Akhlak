@props(['dashboard' => null])

<div class="fi-wi-stats-overview-header-block mb-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-gray-950 dark:text-white">
                Selamat Datang, {{ auth()->user()->name ?? 'Admin' }} 👋
            </h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                Berikut adalah ringkasan kinerja perusahaan saat ini.
            </p>
        </div>
    </div>
</div>
