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

{{-- ══ TÂCHES RÉCENTES EN CARDS ══ --}}
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
    <div class="tm-task-grid">
        @foreach($recentTasks as $task)
            <div class="tm-task-card {{ $task->isOverdue() ? 'tm-task-card-overdue' : '' }}">

                {{-- Badge catégorie --}}
                <div class="tm-task-card-badge">
                    {{ $task->category->name ?? '—' }}
                </div>

                {{-- Titre --}}
                <h3 class="tm-task-card-title">
                    {{ $task->title }}
                    @if($task->isOverdue())
                        <span class="tm-overdue-badge">En retard</span>
                    @endif
                </h3>

                {{-- Description --}}
                <div class="tm-task-card-body {{ !$task->description ? 'tm-task-card-body--empty' : '' }}">
                    <p>{{ $task->description ? Str::limit($task->description, 90) : 'Aucune description' }}</p>
                </div>

                {{-- Échéance --}}
                @if($task->due_date)
                    <div class="tm-due-date {{ $task->isOverdue() ? 'tm-due-overdue' : ($task->daysLeft() <= 2 ? 'tm-due-soon' : 'tm-due-ok') }}">
                        <span>
                            @if($task->isOverdue()) ⚠
                            @elseif($task->daysLeft() <= 2) ⏰
                            @else 📅
                            @endif
                        </span>
                        <span class="tm-due-date-text">{{ $task->due_date->format('d/m/Y') }}</span>
                        <span class="tm-due-label">
                            @if($task->isOverdue())
                                · {{ abs($task->daysLeft()) }}j de retard
                            @elseif($task->daysLeft() == 0)
                                · Aujourd'hui
                            @elseif($task->daysLeft() == 1)
                                · Demain
                            @else
                                · Dans {{ $task->daysLeft() }}j
                            @endif
                        </span>
                    </div>
                @endif

                {{-- Statut --}}
                <div class="tm-task-card-status">
                    <span class="tm-status-dot tm-status-{{ $task->status }}"></span>
                    <span class="tm-badge tm-badge-{{ $task->status }}">
                        {{ match($task->status) {
                            'todo'        => 'À faire',
                            'in_progress' => 'En cours',
                            'done'        => 'Terminé',
                            default       => $task->status
                        } }}
                    </span>
                </div>

                {{-- Actions --}}
                <div class="tm-task-card-actions">
                    <a href="{{ route('tasks.edit', $task) }}" class="tm-btn tm-btn-primary tm-btn-sm">Modifier</a>
                    <form method="POST" action="{{ route('tasks.destroy', $task) }}"
                          onsubmit="return confirm('Supprimer cette tâche ?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="tm-btn tm-btn-danger tm-btn-sm">Supprimer</button>
                    </form>
                </div>

            </div>
        @endforeach
    </div>
@endif

@endsection