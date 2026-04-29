@extends('layouts.app')
@section('title', 'Nouvelle tâche')

@section('content')

<div class="tm-create-wrap">

    <div class="tm-create-header">
        <h1 class="tm-page-title">Nouvelle tâche</h1>
        <p class="tm-page-sub">Ajoutez une tâche à votre liste</p>
    </div>

    <div class="tm-form-card">
        @include('tasks._form', [
            'action' => route('tasks.store'),
            'method' => 'POST',
        ])
    </div>

</div>

@endsection