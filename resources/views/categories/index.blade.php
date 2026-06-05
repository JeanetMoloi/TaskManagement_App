<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Categories
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <div class="mb-4">
                <a href="{{ route('categories.create') }}"
                   class="bg-blue-600 text-white px-4 py-2 rounded">
                    Add Category
                </a>
            </div>

            <div class="bg-white shadow rounded-lg p-6">

                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border p-3">Name</th>
                            <th class="border p-3">Description</th>
                            <th class="border p-3">Color</th>
                            <th class="border p-3">Tasks</th>
                            <th class="border p-3">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($categories as $category)
                            <tr>
                                <td class="border p-3">
                                    {{ $category->name }}
                                </td>

                                <td class="border p-3">
                                    {{ $category->description }}
                                </td>

                                <td class="border p-3">
                                    <div style="width:25px;height:25px;background-color:{{ $category->color }};border-radius:50%;">
                                    </div>
                                </td>

                                <td class="border p-3">
                                    {{ $category->tasks_count }}
                                </td>

                                <td class="border p-3">

                                    <a href="{{ route('categories.edit', $category->id) }}"
                                       class="text-blue-600 mr-3">
                                        Edit
                                    </a>

                                    <form action="{{ route('categories.destroy', $category->id) }}"
                                          method="POST"
                                          class="inline">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                onclick="return confirm('Delete category?')"
                                                class="text-red-600">
                                            Delete
                                        </button>

                                    </form>

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center p-4">
                                    No categories found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>

            </div>

        </div>
    </div>
</x-app-layout>