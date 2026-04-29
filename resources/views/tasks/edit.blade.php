@extends('layouts.app')
@section('title', 'Modifier la tâche')

@section('content')

<div class="tm-page-header">
    <div>
        <h1 class="tm-page-title">Modifier la tâche</h1>
        <p class="tm-page-sub">{{ $task->title }}</p>
    </div>
    <div class="tm-header-actions">
        <a href="{{ route('tasks.index') }}" class="tm-btn tm-btn-ghost">← Retour</a>
        <form method="POST" action="{{ route('tasks.destroy', $task) }}"
              onsubmit="return confirm('Supprimer cette tâche ?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="tm-btn tm-btn-danger">✕ Supprimer</button>
        </form>
    </div>
</div>

<div class="tm-form-card">
    @include('tasks._form', [
        'action' => route('tasks.update', $task),
        'method' => 'PUT',
        'task'   => $task,
    ])
</div>

@endsection