<x-app-layout>

    <div class="max-w-2xl mx-auto mt-10 bg-white shadow-xl rounded-2xl p-8">

        <h1 class="text-3xl font-bold mb-6 text-gray-800">
            Edit Task
        </h1>

        <form method="POST" action="/tasks/{{ $task->id }}">

            @csrf
            @method('PUT')

            <!-- Title -->
            <div class="mb-5">

                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Task Title
                </label>

                <input
                    type="text"
                    name="title"
                    value="{{ $task->title }}"
                    class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                >

            </div>

            <!-- Description -->
            <div class="mb-5">

                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Description
                </label>

                <textarea
                    name="description"
                    rows="5"
                    class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                >{{ $task->description }}</textarea>

            </div>

            <!-- Priority -->
            <div class="mb-5">

                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Priority
                </label>

                <select
                    name="priority"
                    class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                >

                    <option value="Low"
                        {{ $task->priority == 'Low' ? 'selected' : '' }}>
                        Low
                    </option>

                    <option value="Medium"
                        {{ $task->priority == 'Medium' ? 'selected' : '' }}>
                        Medium
                    </option>

                    <option value="High"
                        {{ $task->priority == 'High' ? 'selected' : '' }}>
                        High
                    </option>

                </select>

            </div>

            <!-- Status -->
            <div class="mb-6">

                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Status
                </label>

                <select
                    name="status"
                    class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-green-400 focus:outline-none"
                >

                    <option value="Pending"
                        {{ $task->status == 'Pending' ? 'selected' : '' }}>
                        Pending
                    </option>

                    <option value="In Progress"
                        {{ $task->status == 'In Progress' ? 'selected' : '' }}>
                        In Progress
                    </option>

                    <option value="Completed"
                        {{ $task->status == 'Completed' ? 'selected' : '' }}>
                        Completed
                    </option>

                </select>

            </div>

            <!-- Buttons -->
            <div class="flex gap-4">

                <button
                    type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl transition"
                >
                    Update Task
                </button>

                <a
                    href="/tasks"
                    class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-3 rounded-xl transition"
                >
                    Cancel
                </a>

            </div>

        </form>

    </div>

</x-app-layout>