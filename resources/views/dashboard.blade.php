<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium mb-2">{{ __("স্বাগতম, ") }} {{ Auth::user()->name }}!</h3>
                    <p class="text-gray-600">{{ __("আপনি সফলভাবে লগইন করেছেন। নিচের কার্ডগুলো থেকে আপনার পছন্দের সেকশনে যান।") }}</p>
                </div>
            </div>

            <!-- Quick Access Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                
                <!-- Audio Management Card -->
                <a href="{{ route('admin.audios.index') }}" class="transform hover:scale-105 transition duration-300">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg h-full">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-purple-500 bg-opacity-20">
                                    <svg class="h-8 w-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-semibold text-gray-900">অডিও ব্যবস্থাপনা</h3>
                                    <p class="text-gray-600 text-sm">অডিও ফাইল আপলোড ও পরিচালনা করুন</p>
                                </div>
                            </div>
                            <div class="mt-4">
                                <p class="text-2xl font-bold text-purple-600">{{ \App\Models\Audio::count() }}</p>
                                <p class="text-gray-500 text-sm">মোট অডিও</p>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- PDF Management Card -->
                <a href="{{ route('admin.pdfs.index') }}" class="transform hover:scale-105 transition duration-300">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg h-full">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-red-500 bg-opacity-20">
                                    <svg class="h-8 w-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-semibold text-gray-900">PDF ব্যবস্থাপনা</h3>
                                    <p class="text-gray-600 text-sm">PDF ফাইল আপলোড ও পরিচালনা করুন</p>
                                </div>
                            </div>
                            <div class="mt-4">
                                <p class="text-2xl font-bold text-red-600">{{ \App\Models\Pdf::count() }}</p>
                                <p class="text-gray-500 text-sm">মোট PDF</p>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Statistics Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-500 bg-opacity-20">
                                <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-gray-900">পরিসংখ্যান</h3>
                                <p class="text-gray-600 text-sm">সামগ্রিক পরিসংখ্যান</p>
                            </div>
                        </div>
                        <div class="mt-4 space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-500 text-sm">মোট প্লে:</span>
                                <span class="font-semibold">{{ \App\Models\Audio::sum('play_count') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500 text-sm">মোট ডাউনলোড:</span>
                                <span class="font-semibold">{{ \App\Models\Pdf::sum('download_count') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Quick Actions -->
            <div class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">দ্রুত কার্যক্রম</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <a href="{{ route('admin.audios.create') }}" class="inline-flex items-center justify-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 focus:bg-purple-700 active:bg-purple-900 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            নতুন অডিও যুক্ত করুন
                        </a>
                        <a href="{{ route('admin.pdfs.create') }}" class="inline-flex items-center justify-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            নতুন PDF যুক্ত করুন
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
