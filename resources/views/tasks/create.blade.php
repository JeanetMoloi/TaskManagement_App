<x-app-layout>

<div class="max-w-xl mx-auto mt-10 bg-white p-6 rounded shadow">

    <h1 class="text-2xl font-bold mb-6">
        Create Task
    </h1>

    <form method="POST" action="/tasks">

        @csrf

        <div class="mb-4">
            <label class="block mb-2">Title</label>

            <input type="text"
                   name="title"
                   class="w-full border rounded p-2">
        </div>

        <div class="mb-4">
            <label class="block mb-2">Description</label>

            <textarea name="description"
                      class="w-full border rounded p-2"></textarea>
        </div>

        <div class="mb-4">
            <label class="block mb-2">Priority</label>

            <select name="priority"
                    class="w-full border rounded p-2">

                <option>Low</option>
                <option>Medium</option>
                <option>High</option>

            </select>
        </div>

        <button class="bg-blue-500 text-white px-4 py-2 rounded">
            Save Task
        </button>

    </form>

</div>

</x-app-layout>