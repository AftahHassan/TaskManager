@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')

{{-- ══ HEADER ══ --}}
<div class="tm-page-header">
    <div>
        <h1 class="tm-page-title">Dashboard</h1>
        <p class="tm-page-sub">Bonjour, {{ auth()->user()->name }} 👋</p>
    </div>
</div>

{{-- ══ STATS ══ --}}
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

{{-- ══ TÂCHES RÉCENTES ══ --}}
<div class="tm-section-header">
    <h2 class="tm-section-title">
        Tâches récentes
        <span class="tm-section-count">{{ $recentTasks->total() }}</span>
    </h2>
    <a href="{{ route('tasks.index') }}" class="tm-link">Voir tout →</a>
</div>

@if($recentTasks->isEmpty())
    <div class="tm-empty">
        <span class="tm-empty-icon">◈</span>
        <p>Aucune tâche pour le moment.</p>
        <a href="{{ route('tasks.create') }}" class="tm-btn tm-btn-primary">
            Créer ma première tâche
        </a>
    </div>
@else
    <div class="tm-task-grid">
        @foreach($recentTasks as $task)
            <div class="tm-task-card {{ $task->isOverdue() ? 'tm-task-card-overdue' : '' }}">

                {{-- Catégorie + Statut --}}
                <div class="tm-task-card-top">
                    <span class="tm-task-card-badge">{{ $task->category->name ?? '—' }}</span>
                    <span class="tm-badge tm-badge-{{ $task->status }}">
                        {{ match($task->status) {
                            'todo'        => 'À faire',
                            'in_progress' => 'En cours',
                            'done'        => 'Terminé',
                            default       => $task->status
                        } }}
                    </span>
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
                        <span>@if($task->isOverdue()) ⚠ @elseif($task->daysLeft() <= 2) ⏰ @else 📅 @endif</span>
                        <span class="tm-due-date-text">{{ $task->due_date->format('d/m/Y') }}</span>
                        <span class="tm-due-label">
                            @if($task->isOverdue()) · {{ abs($task->daysLeft()) }}j de retard
                            @elseif($task->daysLeft() == 0) · Aujourd'hui
                            @elseif($task->daysLeft() == 1) · Demain
                            @else · Dans {{ $task->daysLeft() }}j
                            @endif
                        </span>
                    </div>
                @endif

                {{-- Footer card : date création seulement --}}
                <div class="tm-task-card-footer">
                    <span class="tm-task-card-date">
                        📌 {{ $task->created_at->format('d/m/Y') }}
                    </span>
                    <a href="{{ route('tasks.index') }}" class="tm-card-view-link">
                        Voir toutes →
                    </a>
                </div>

            </div>
        @endforeach
    </div>

    {{-- PAGINATION --}}
    <div class="tm-pagination">
        {{ $recentTasks->links() }}
    </div>
@endif

@endsection