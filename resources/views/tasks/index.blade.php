@extends('layouts.app')
@section('title', 'Mes tâches')

@section('content')

<div class="tm-page-header">
    <div>
        <h1 class="tm-page-title">Mes tâches</h1>
        <p class="tm-page-sub">{{ $tasks->total() }} tâche(s) au total</p>
    </div>
    <a href="{{ route('tasks.create') }}" class="tm-btn tm-btn-primary">⊕ Nouvelle tâche</a>
</div>

{{-- ══ FILTRES ══ --}}
<form method="GET" action="{{ route('tasks.index') }}" class="tm-filters">
    <select name="status" class="tm-select">
        <option value="">Tous les statuts</option>
        <option value="todo"        {{ request('status') === 'todo'        ? 'selected' : '' }}>À faire</option>
        <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>En cours</option>
        <option value="done"        {{ request('status') === 'done'        ? 'selected' : '' }}>Terminé</option>
    </select>

    <select name="category_id" class="tm-select">
        <option value="">Toutes les catégories</option>
        @foreach($categories as $cat)
            <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                {{ $cat->name }}
            </option>
        @endforeach
    </select>

    <button type="submit" class="tm-btn tm-btn-secondary">Filtrer</button>
    <a href="{{ route('tasks.index') }}" class="tm-btn tm-btn-ghost">Réinitialiser</a>
</form>

{{-- ══ TABLEAU DES TÂCHES ══ --}}
@if($tasks->isEmpty())
    <div class="tm-empty">
        <span class="tm-empty-icon">◈</span>
        <p>Aucune tâche trouvée.</p>
        <a href="{{ route('tasks.create') }}" class="tm-btn tm-btn-primary">Créer une tâche</a>
    </div>
@else
    <div class="tm-table-wrap">
        <table class="tm-table">
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Catégorie</th>
                    <th>Statut</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tasks as $task)
                <tr class="tm-table-row">
                    <td>
                        <div class="tm-task-title-cell">
                            <span class="tm-status-dot tm-status-{{ $task->status }}"></span>
                            {{ $task->title }}
                        </div>
                        @if($task->description)
                            <p class="tm-task-desc">{{ Str::limit($task->description, 60) }}</p>
                        @endif
                    </td>
                    <td>
                        <span class="tm-category-tag">{{ $task->category->name ?? '—' }}</span>
                    </td>
                    <td>
                        <span class="tm-badge tm-badge-{{ $task->status }}">
                            {{ match($task->status) {
                                'todo'        => 'À faire',
                                'in_progress' => 'En cours',
                                'done'        => 'Terminé',
                                default       => $task->status
                            } }}
                        </span>
                    </td>
                    <td class="tm-date-cell">{{ $task->created_at->format('d/m/Y') }}</td>
                    <td>
                        <div class="tm-actions">
                            <a href="{{ route('tasks.edit', $task) }}" class="tm-icon-btn" title="Modifier">✎</a>
                            <form method="POST" action="{{ route('tasks.destroy', $task) }}"
                                  onsubmit="return confirm('Supprimer cette tâche ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="tm-icon-btn tm-icon-btn-danger" title="Supprimer">✕</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- PAGINATION --}}
    <div class="tm-pagination">
        {{ $tasks->withQueryString()->links() }}
    </div>
@endif

@endsection