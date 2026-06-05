<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Category
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto bg-white p-6 shadow rounded">

            <form method="POST"
                  action="{{ route('categories.update', $category->id) }}">

                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block mb-2">Category Name</label>

                    <input type="text"
                           name="name"
                           value="{{ $category->name }}"
                           class="w-full border rounded p-2"
                           required>
                </div>

                <div class="mb-4">
                    <label class="block mb-2">Description</label>

                    <textarea name="description"
                              class="w-full border rounded p-2">{{ $category->description }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="block mb-2">Color</label>

                    <input type="color"
                           name="color"
                           value="{{ $category->color }}"
                           class="w-full border rounded p-2">
                </div>

                <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded">
                    Update Category
                </button>

            </form>

        </div>
    </div>
</x-app-layout>