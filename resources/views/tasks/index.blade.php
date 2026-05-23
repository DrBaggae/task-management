<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tasks
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                {{-- Search and Filter --}}
                <form method="GET" action="{{ route('tasks.index') }}" class="mb-6 flex gap-4 flex-wrap">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search tasks..." class="border rounded px-3 py-2">
                    <select name="status" class="border rounded px-3 py-2">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                    <select name="priority" class="border rounded px-3 py-2">
                        <option value="">All Priority</option>
                        <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Low</option>
                        <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>High</option>
                    </select>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Filter</button>
                    <a href="{{ route('tasks.index') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded">Reset</a>
                </form>

                {{-- Create Button --}}
                <div class="mb-4">
                    <a href="{{ route('tasks.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">+ New Task</a>
                </div>

                {{-- Task Table --}}
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="p-3 border">Title</th>
                            <th class="p-3 border">Status</th>
                            <th class="p-3 border">Priority</th>
                            <th class="p-3 border">Due Date</th>
                            <th class="p-3 border">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tasks as $task)
                        <tr class="border-t">
                            <td class="p-3 border">{{ $task->title }}</td>
                            <td class="p-3 border">{{ ucfirst($task->status) }}</td>
                            <td class="p-3 border">{{ ucfirst($task->priority) }}</td>
                            <td class="p-3 border">{{ $task->due_date ?? '-' }}</td>
                            <td class="p-3 border flex gap-2">
                                <a href="{{ route('tasks.edit', $task) }}" class="bg-yellow-400 text-white px-3 py-1 rounded">Edit</a>
                                <form method="POST" action="{{ route('tasks.destroy', $task) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Delete this task?')" class="bg-red-500 text-white px-3 py-1 rounded">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="p-3 text-center text-gray-500">No tasks found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- Pagination --}}
                <div class="mt-4">
                    {{ $tasks->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>