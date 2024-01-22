<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __($library->name . ' Books') }}
        </h2>
    </x-slot>

    <div class="pt-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-6 pt-6 relative overflow-x-auto shadow-md sm:rounded-lg">
                    @if (session('book-borrowed'))
                        <x-auth-session-status class="mb-4" :status="session('book-borrowed')" />
                    @endif
                    @if (session('book-not-borrowed'))
                        <x-auth-session-status class="mb-4" :status="session('book-not-borrowed')" />
                    @endif
                    @if (session('book-returned'))
                        <x-auth-session-status class="mb-4" :status="session('book-returned')" />
                    @endif
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                @foreach($columns as $column)
                                    <th scope="col" class="px-6 py-3">
                                      {{ $column }}
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($books as $item)
                                <tr class="bg-white border dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $item->book->name }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $item->book->author }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $item->book->publishedAt() }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($item->user_id == auth()->user()->id)
                                        <a href="{{ route('library-books.return', $item) }}">
                                            <x-primary-button>
                                                {{ __('Return') }}
                                            </x-primary-button>
                                        </a>
                                        @else
                                        <a href="{{ route('library-books.borrow', $item) }}">
                                            <x-info-button :disable="!$item->user_id ? '' : __('disabled')">
                                                {{ __('Borrow') }}
                                            </x-info-button>
                                        </a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr class="bg-white border dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td colspan="4" scope="row" class="text-center px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ __('No Books Found') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="py-6">
                        {{ $books->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>