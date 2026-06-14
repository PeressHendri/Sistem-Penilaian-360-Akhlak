<x-filament-widgets::widget>
    <x-filament::section>
        <div class="space-y-6">
            <!-- Aksi Cepat -->
            <div>
                <h3 class="text-base font-semibold text-gray-900 dark:text-white mb-3">Aksi Cepat</h3>
                <div class="space-y-2">
                    <a href="/admin/employees/create"
                       class="flex items-center justify-between w-full px-4 py-3 bg-gray-50 dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors group">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-green-100 flex items-center justify-center">
                                <x-heroicon-m-user-plus class="w-4 h-4 text-green-700" />
                            </div>
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-200">Tambah Karyawan</span>
                        </div>
                        <x-heroicon-m-chevron-right class="w-4 h-4 text-gray-400 group-hover:text-gray-600" />
                    </a>

                    <a href="/admin/assessment-programs/create"
                       class="flex items-center justify-between w-full px-4 py-3 bg-gray-50 dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors group">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center">
                                <x-heroicon-m-document-plus class="w-4 h-4 text-blue-700" />
                            </div>
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-200">Buat Form Baru</span>
                        </div>
                        <x-heroicon-m-chevron-right class="w-4 h-4 text-gray-400 group-hover:text-gray-600" />
                    </a>
                </div>
            </div>

            <!-- System Health -->
            <div>
                <div class="flex items-center gap-2 mb-3">
                    <h3 class="text-base font-semibold text-gray-900 dark:text-white">System Health</h3>
                    <span class="inline-block w-2.5 h-2.5 rounded-full bg-green-500 animate-pulse"></span>
                </div>

                <div class="space-y-3">
                    <!-- Database Load -->
                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-xs text-gray-500 dark:text-gray-400">Database Load</span>
                            <span class="text-xs font-semibold text-gray-700 dark:text-gray-200">24%</span>
                        </div>
                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-1.5">
                            <div class="bg-green-500 h-1.5 rounded-full" style="width: 24%"></div>
                        </div>
                    </div>

                    <!-- Storage Used -->
                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-xs text-gray-500 dark:text-gray-400">Storage Used</span>
                            <span class="text-xs font-semibold text-gray-700 dark:text-gray-200">68%</span>
                        </div>
                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-1.5">
                            <div class="bg-red-500 h-1.5 rounded-full" style="width: 68%"></div>
                        </div>
                    </div>

                    <!-- Active Sessions -->
                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-xs text-gray-500 dark:text-gray-400">Active Sessions</span>
                            <span class="text-xs font-semibold text-gray-700 dark:text-gray-200">12</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
