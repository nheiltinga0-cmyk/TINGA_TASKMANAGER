@extends('layouts.app')

@section('content')
    <div class="form-wrap">
        <p class="eyebrow">Refine your list</p>
        <h1>Edit task.</h1>
        <div class="form-card">
            <form method="POST" action="{{ route('tasks.update', [$task], false) }}">
                @csrf
                @method('PUT')
                @include('tasks.form', ['submitLabel' => 'Save changes'])
            </form>
        </div>
    </div>
@endsection