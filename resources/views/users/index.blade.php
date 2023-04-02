<x-app-layout>

    <x-slot name="pageTitle">
        Article List
    </x-slot>

    @if (session('success'))
    <div class="max-w-4xl mx-auto mt-8 bg-green-700 text-white p-3 rounded-lg">
        {{ session('success') }}
    </div>
    @endif

    <div class="overflow-x-auto max-w-4xl mx-auto my-12 relative shadow-md sm:rounded-lg bg-white">
        <div class="p-5 bg-white flex items-center justify-between">
            <form action="{{ route('articles.index') }}" method="GET">
                <label for="table-search" class="sr-only">Search</label>
                <div class="relative mt-1">
                    <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <input name="query" value="{{ request('query') }}" type="text" id="table-search" class="block p-2 pl-10 w-80 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 " placeholder="Search for items">
                </div>
            </form>

            <a href="{{ route('users.create') }}" class="px-5 py-2 rounded-lg bg-gray-800 hover:opacity-80 text-white">Create User</a>
        </div>


        {{-- Pagination --}}
        <div class="p-4">
            {{ $listUsers->links() }}
        </div>
    </div>


</x-app-layout>