<div class="hidden md:flex md:w-64 md:flex-col">
    <div class="flex flex-col flex-grow pt-5 overflow-y-auto bg-gray-900">
        <div class="flex items-center flex-shrink-0 px-4">
            <h2 class="text-xl font-semibold text-white">Audio QR System</h2>
        </div>
        <div class="mt-8 flex-grow flex flex-col">
            <nav class="flex-1 px-2 pb-4 space-y-1">
                <!-- Dashboard -->
                <a href="{{ route('dashboard') }}" 
                   class="{{ request()->routeIs('dashboard') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                    <svg class="{{ request()->routeIs('dashboard') ? 'text-gray-300' : 'text-gray-400 group-hover:text-gray-300' }} mr-3 h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Dashboard
                </a>

                <!-- Audio Management -->
                <a href="{{ route('admin.audios.index') }}" 
                   class="{{ request()->routeIs('admin.audios.*') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                    <svg class="{{ request()->routeIs('admin.audios.*') ? 'text-gray-300' : 'text-gray-400 group-hover:text-gray-300' }} mr-3 h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path>
                    </svg>
                    অডিও ব্যবস্থাপনা
                </a>

                <!-- PDF Management -->
                <a href="{{ route('admin.pdfs.index') }}" 
                   class="{{ request()->routeIs('admin.pdfs.*') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                    <svg class="{{ request()->routeIs('admin.pdfs.*') ? 'text-gray-300' : 'text-gray-400 group-hover:text-gray-300' }} mr-3 h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                    PDF ব্যবস্থাপনা
                </a>

                <!-- Quick Add Section -->
                <div class="mt-8">
                    <h3 class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        দ্রুত যুক্ত করুন
                    </h3>
                    <div class="mt-3 space-y-1">
                        <a href="{{ route('admin.audios.create') }}" 
                           class="text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <svg class="text-gray-400 group-hover:text-gray-300 mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            নতুন অডিও
                        </a>
                        <a href="{{ route('admin.pdfs.create') }}" 
                           class="text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <svg class="text-gray-400 group-hover:text-gray-300 mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            নতুন PDF
                        </a>
                    </div>
                </div>

                <!-- User Section -->
                <div class="mt-8">
                    <h3 class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        ব্যবহারকারী
                    </h3>
                    <div class="mt-3 space-y-1">
                        <a href="{{ route('profile.edit') }}" 
                           class="{{ request()->routeIs('profile.edit') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <svg class="{{ request()->routeIs('profile.edit') ? 'text-gray-300' : 'text-gray-400 group-hover:text-gray-300' }} mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            প্রোফাইল
                        </a>
                    </div>
                </div>
            </nav>
        </div>

        <!-- User Info -->
        <div class="flex-shrink-0 flex border-t border-gray-800 p-4">
            <div class="flex-shrink-0 w-full group block">
                <div class="flex items-center">
                    <div class="inline-flex items-center justify-center h-9 w-9 rounded-full bg-gray-700">
                        <span class="text-sm font-medium leading-none text-white">{{ substr(Auth::user()->name, 0, 1) }}</span>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-white">
                            {{ Auth::user()->name }}
                        </p>
                        <p class="text-xs font-medium text-gray-400">
                            {{ Auth::user()->email }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
