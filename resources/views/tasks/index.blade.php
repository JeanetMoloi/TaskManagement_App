<x-app-layout>

<div class="py-10 px-6 bg-gray-100 min-h-screen">

<!-- Page Header -->
<div class="flex justify-between items-center mb-8">

<div>
<h1 class="text-4xl font-bold text-gray-800">
Task Dashboard
</h1>

<p class="text-gray-500 mt-1">
Manage your tasks efficiently
</p>
</div>

<!-- Add Task Button -->
<a href="/tasks/create"
class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-xl shadow-lg transition">

+ Add Task

</a>

</div>

<!-- Task Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

@forelse($tasks as $task)

<div class="bg-white rounded-2xl shadow-lg p-6 hover:shadow-2xl transition">

<!-- Task Title -->
<h2 class="text-2xl font-bold text-gray-800 mb-3">

{{ $task->title }}

</h2>

<!-- Description -->
<p class="text-gray-600 mb-4">

{{ $task->description }}

</p>

<!-- Status -->
<div class="mb-2">

<span class="font-semibold text-gray-700">
Status:
</span>

<span class="text-blue-600 font-medium">

{{ $task->status }}

</span>

</div>

<!-- Priority -->
<div class="mb-4">

<span class="font-semibold text-gray-700">
Priority:
</span>

<span class="text-red-500 font-medium">

{{ $task->priority }}

</span>

</div>

<!-- Buttons -->
<div class="flex gap-3 mt-5">

<!-- View -->
<a href="/tasks/{{ $task->id }}"
class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg transition">

View

</a>

<!-- Edit -->
<a href="/tasks/{{ $task->id }}/edit"
class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg transition">

Edit

</a>

</div>

</div>

@empty

<!-- Empty State -->
<div class="col-span-3">

<div class="bg-white rounded-2xl shadow-lg p-10 text-center">

<h2 class="text-2xl font-bold text-gray-700 mb-3">
No Tasks Yet
</h2>

<p class="text-gray-500 mb-5">
Start by creating your first task.
</p>

<a href="/tasks/create"
class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-xl transition">

Create Task

</a>

</div>

</div>

@endforelse

</div>

</div>

</x-app-layout>
