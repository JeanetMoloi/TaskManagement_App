<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create Category
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto bg-white p-6 shadow rounded">

            <form method="POST" action="{{ route('categories.store') }}">

                @csrf

                <div class="mb-4">
                    <label class="block mb-2">Category Name</label>
                    <input type="text"
                           name="name"
                           class="w-full border rounded p-2"
                           required>
                </div>

                <div class="mb-4">
                    <label class="block mb-2">Description</label>
                    <textarea name="description"
                              class="w-full border rounded p-2"></textarea>
                </div>

                <div class="mb-4">
                    <label class="block mb-2">Color</label>
                    <input type="color"
                           name="color"
                           class="w-full border rounded p-2">
                </div>

                <button type="submit"
                        class="bg-green-600 text-white px-4 py-2 rounded">
                    Save Category
                </button>

            </form>

        </div>
    </div>
</x-app-layout>