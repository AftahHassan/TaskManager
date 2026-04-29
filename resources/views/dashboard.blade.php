@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')

<div class="tm-page-header">
    <div>
        <h1 class="tm-page-title">Dashboard</h1>
        <p class="tm-page-sub">Bonjour, {{ auth()->user()->name }} 👋</p>
    </div>
    <a href="{{ route('tasks.create') }}" class="tm-btn tm-btn-primary">
        ⊕ Nouvelle tâche
    </a>
</div>

{{-- ══ STATS CARDS ══ --}}
<div class="tm-stats-grid">

    <div class="tm-stat-card tm-stat-total">
        <div class="tm-stat-icon">◧</div>
        <div class="tm-stat-info">
            <span class="tm-stat-number">{{ $stats['total'] }}</span>
            <span class="tm-stat-label">Total tâches</span>
        </div>
    </div>

    <div class="tm-stat-card tm-stat-todo">
        <div class="tm-stat-icon">○</div>
        <div class="tm-stat-info">
            <span class="tm-stat-number">{{ $stats['todo'] }}</span>
            <span class="tm-stat-label">À faire</span>
        </div>
    </div>

    <div class="tm-stat-card tm-stat-progress">
        <div class="tm-stat-icon">◑</div>
        <div class="tm-stat-info">
            <span class="tm-stat-number">{{ $stats['in_progress'] }}</span>
            <span class="tm-stat-label">En cours</span>
        </div>
    </div>

    <div class="tm-stat-card tm-stat-done">
        <div class="tm-stat-icon">●</div>
        <div class="tm-stat-info">
            <span class="tm-stat-number">{{ $stats['done'] }}</span>
            <span class="tm-stat-label">Terminées</span>
        </div>
    </div>

</div>

{{-- ══ RECENT TASKS ══ --}}
<div class="tm-section">
    <div class="tm-section-header">
        <h2 class="tm-section-title">Tâches récentes</h2>
        <a href="{{ route('tasks.index') }}" class="tm-link">Voir tout →</a>
    </div>

    @if($recentTasks->isEmpty())
        <div class="tm-empty">
            <span class="tm-empty-icon">◈</span>
            <p>Aucune tâche pour le moment.</p>
            <a href="{{ route('tasks.create') }}" class="tm-btn tm-btn-primary">Créer ma première tâche</a>
        </div>
    @else
        <div class="tm-task-list">
            @foreach($recentTasks as $task)
                <div class="tm-task-row">
                    <div class="tm-task-left">
                        <span class="tm-status-dot tm-status-{{ $task->status }}"></span>
                        <div>
                            <p class="tm-task-title">{{ $task->title }}</p>
                            <p class="tm-task-meta">
                                {{ $task->category->name ?? '—' }}
                            </p>
                        </div>
                    </div>
                    <div class="tm-task-right">
                        <span class="tm-badge tm-badge-{{ $task->status }}">
                            {{ match($task->status) {
                                'todo'        => 'À faire',
                                'in_progress' => 'En cours',
                                'done'        => 'Terminé',
                                default       => $task->status
                            } }}
                        </span>
                        <a href="{{ route('tasks.edit', $task) }}" class="tm-icon-btn" title="Modifier">✎</a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

@endsection