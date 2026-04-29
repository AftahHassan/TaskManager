@extends('layouts.app')
@section('title', 'Nouvelle tâche')

@section('content')

<div class="tm-page-header">
    <div>
        <h1 class="tm-page-title">Nouvelle tâche</h1>
        <p class="tm-page-sub">Ajoutez une tâche à votre liste</p>
    </div>
    <a href="{{ route('tasks.index') }}" class="tm-btn tm-btn-ghost">← Retour</a>
</div>

<div class="tm-form-card">
    @include('tasks._form', [
        'action' => route('tasks.store'),
        'method' => 'POST',
    ])
</div>

@endsection