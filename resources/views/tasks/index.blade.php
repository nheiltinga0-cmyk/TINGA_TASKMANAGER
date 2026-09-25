@extends('layouts.app')

@section('content')
    <div class="intro">
        <div class="intro-copy">
            <p class="eyebrow">Personal Task Manager</p>
            <h1>Make room for<br>important things.</h1>
            <p>Keep your day moving with a simple list that makes progress visible.</p>
        </div>
        <a class="button" href="{{ route('tasks.create', [], false) }}"><span aria-hidden="true">+</span> Add a task</a>
    </div>

    <div class="stats">
        <div class="stat accent"><strong>{{ $tasks->count() }}</strong><span>Total tasks</span></div>
        <div class="stat"><strong>{{ $tasks->where('status', 'pending')->count() }}</strong><span>Still to do</span></div>
        <div class="stat"><strong>{{ $completedCount }}</strong><span>Completed</span></div>
    </div>

    <div class="section-heading">
        <h2>Your tasks</h2>
        <span>{{ $tasks->count() }} {{ Str::plural('item', $tasks->count()) }}</span>
    </div>

    @if ($tasks->isEmpty())
        <div class="empty">
            <strong>Your list is clear.</strong>
            <p>Add your first task and turn intention into momentum.</p>
            <a class="button" href="{{ route('tasks.create', [], false) }}">Create first task</a>
        </div>
    @else
        <div class="task-list">
            @foreach ($tasks as $task)
                <article class="task {{ $task->status === 'completed' ? 'completed' : '' }}">
                    <form method="POST" action="{{ route('tasks.status', [$task], false) }}">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="{{ $task->status === 'completed' ? 'pending' : 'completed' }}">
                        <button class="status-toggle" type="submit" aria-label="Mark task {{ $task->status === 'completed' ? 'pending' : 'completed' }}">{{ $task->status === 'completed' ? '✓' : '' }}</button>
                    </form>
                    <div>
                        <h3 class="task-title">{{ $task->title }}</h3>
                        @if ($task->description)<p class="task-description">{{ $task->description }}</p>@endif
                        <p class="task-date">Added {{ $task->created_at->format('M j, Y') }}</p>
                    </div>
                    <div class="task-actions">
                        <span class="status {{ $task->status }}">{{ $task->status }}</span>
                        <a class="action-link" href="{{ route('tasks.edit', [$task], false) }}">Edit</a>
                        <form method="POST" action="{{ route('tasks.destroy', [$task], false) }}" onsubmit="return confirm('Delete this task?')">
                            @csrf
                            @method('DELETE')
                            <button class="action-link delete" type="submit">Delete</button>
                        </form>
                    </div>
                </article>
            @endforeach
        </div>
    @endif
@endsection