<x-app-layout>

    <div class="max-w-3xl mx-auto mt-10">

        <!-- Card -->
        <div class="bg-white shadow-2xl rounded-2xl overflow-hidden">

            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 p-6">

                <h1 class="text-4xl font-bold text-white">
                    {{ $task->title }}
                </h1>

                <p class="text-blue-100 mt-2">
                    Task Details
                </p>

            </div>

            <!-- Content -->
            <div class="p-8 space-y-6">

                <!-- Description -->
                <div>

                    <h2 class="text-lg font-semibold text-gray-700 mb-2">
                        Description
                    </h2>

                    <p class="text-gray-600 leading-relaxed">
                        {{ $task->description }}
                    </p>

                </div>

                <!-- Status -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div class="bg-gray-100 rounded-xl p-5">

                        <h3 class="text-sm font-semibold text-gray-500 uppercase">
                            Status
                        </h3>

                        <p class="mt-2 text-xl font-bold text-gray-800">
                            {{ $task->status }}
                        </p>

                    </div>

                    <!-- Priority -->
                    <div class="bg-gray-100 rounded-xl p-5">

                        <h3 class="text-sm font-semibold text-gray-500 uppercase">
                            Priority
                        </h3>

                        <p class="mt-2 text-xl font-bold text-gray-800">
                            {{ $task->priority }}
                        </p>

                    </div>

                </div>

                <!-- Assigned User -->
                <div class="bg-gray-100 rounded-xl p-5">

                    <h3 class="text-sm font-semibold text-gray-500 uppercase">
                        Assigned To
                    </h3>

                    <p class="mt-2 text-xl font-bold text-gray-800">

                        @if($task->user)
                            {{ $task->user->name }}
                        @else
                            No User Assigned
                        @endif

                    </p>

                </div>

                <!-- Due Date -->
                <div class="bg-gray-100 rounded-xl p-5">

                    <h3 class="text-sm font-semibold text-gray-500 uppercase">
                        Deadline
                    </h3>

                    <p class="mt-2 text-xl font-bold text-gray-800">

                        @if($task->due_date)
                            {{ $task->due_date }}
                        @else
                            No Deadline Set
                        @endif

                    </p>

                </div>

                <!-- Buttons -->
                <div class="flex gap-4 pt-6">

                    <a
                        href="/tasks/{{ $task->id }}/edit"
                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-3 rounded-xl transition"
                    >
                        Edit Task
                    </a>

                    <a
                        href="/tasks"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-3 rounded-xl transition"
                    >
                        Back
                    </a>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>