<div class="field">
    <label for="title">Task title</label>
    <input id="title" name="title" type="text" value="{{ old('title', $task->title ?? '') }}" placeholder="e.g. Plan the week" required autofocus>
    @error('title') <p class="error">{{ $message }}</p> @enderror
</div>
<div class="field">
    <label for="description">Notes <span style="font-weight: 400; color: var(--muted);">(optional)</span></label>
    <textarea id="description" name="description" placeholder="Add a little context...">{{ old('description', $task->description ?? '') }}</textarea>
    @error('description') <p class="error">{{ $message }}</p> @enderror
</div>
<div class="form-actions">
    <button class="button" type="submit">{{ $submitLabel }}</button>
    <a class="action-link" href="{{ route('tasks.index', [], false) }}">Cancel</a>
</div>