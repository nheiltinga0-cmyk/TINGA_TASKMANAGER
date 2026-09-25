@extends('layouts.app')

@section('content')
    <div class="form-wrap">
        <p class="eyebrow">New task</p>
        <h1>What needs your attention?</h1>
        <div class="form-card">
            <form method="POST" action="{{ route('tasks.store', [], false) }}">
                @csrf
                @include('tasks.form', ['submitLabel' => 'Add task'])
            </form>
        </div>
    </div>
@endsection