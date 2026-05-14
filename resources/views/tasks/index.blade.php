<x-app-layout>

    <div class="py-6 px-6">

        <h1 class="text-3xl font-bold mb-6">
            Task Dashboard
        </h1>

        <a href="/tasks/create"
           class="bg-blue-500 text-white px-4 py-2 rounded">
            Add Task
        </a>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">

            @foreach($tasks as $task)

                <div class="bg-white shadow-lg rounded-xl p-6">

                    <h2 class="text-xl font-bold">
                        {{ $task->title }}
                    </h2>

                    <p class="text-gray-600 mt-2">
                        {{ $task->description }}
                    </p>

                    <div class="mt-4">
                        <span class="font-bold">
                            Status:
                        </span>

                        {{ $task->status }}
                    </div>

                    <div>
                        <span class="font-bold">
                            Priority:
                        </span>

                        {{ $task->priority }}
                    </div>

                    <div class="mt-4 flex gap-2">

                        <a href="/tasks/{{ $task->id }}/edit"
                           class="bg-yellow-500 text-white px-3 py-1 rounded">
                            Edit
                        </a>

                        <a href="/tasks/{{ $task->id }}"
                           class="bg-green-500 text-white px-3 py-1 rounded">
                            View
                        </a>

                    </div>

                </div>

            @endforeach

        </div>

    </div>

</x-app-layout>