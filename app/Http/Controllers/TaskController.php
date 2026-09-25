<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends Controller
{
    public function index(): View
    {
        $tasks = Task::query()->latest()->get();
        $completedCount = $tasks->where('status', 'completed')->count();

        return view('tasks.index', [
            'tasks' => $tasks,
            'completedCount' => $completedCount,
        ]);
    }

    public function create(): View
    {
        return view('tasks.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:120'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        Task::create($validated + ['status' => 'pending']);

        return $this->redirectToTasks('Task added to your list.');
    }

    public function edit(Task $task): View
    {
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:120'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        $task->update($validated);

        return $this->redirectToTasks('Task updated.');
    }

    public function destroy(Task $task): RedirectResponse
    {
        $task->delete();

        return $this->redirectToTasks('Task deleted.');
    }

    public function updateStatus(Request $request, Task $task): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:pending,completed'],
        ]);

        $task->update($validated);

        return $this->redirectToTasks('Task status updated.');
    }

    private function redirectToTasks(string $message): RedirectResponse
    {
        session()->flash('success', $message);

        return new RedirectResponse('/tasks', Response::HTTP_FOUND);
    }
}