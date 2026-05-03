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
    <div class="tm-filters-divider"></div>
    <select name="category_id" class="tm-select">
        <option value="">Toutes les catégories</option>
        @foreach($categories as $cat)
            <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                {{ $cat->name }}
            </option>
        @endforeach
    </select>
    <div class="tm-filters-divider"></div>
    <button type="submit" class="tm-btn tm-btn-secondary">Filtrer</button>
    <a href="{{ route('tasks.index') }}" class="tm-btn tm-btn-ghost">Réinitialiser</a>
</form>

{{-- ══ TABLEAU ══ --}}
@if($tasks->isEmpty())
    <div class="tm-table-wrap">
        <div class="tm-empty">
            <span class="tm-empty-icon">◈</span>
            <p>Aucune tâche trouvée.</p>
            <a href="{{ route('tasks.create') }}" class="tm-btn tm-btn-primary">Créer une tâche</a>
        </div>
    </div>
@else
    <div class="tm-table-wrap">
        <table class="tm-table">
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Catégorie</th>
                    <th>Statut</th>
                    <th>Échéance</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tasks as $task)
                <tr class="tm-table-row {{ $task->isOverdue() ? 'tm-row-overdue' : '' }}">

                    <td>
                        <div class="tm-task-title-cell">
                            <span class="tm-status-dot tm-status-{{ $task->status }}"></span>
                            <div>
                                <p class="tm-task-name {{ $task->isOverdue() ? 'tm-overdue-text' : '' }}">
                                    {{ $task->title }}
                                    @if($task->isOverdue())
                                        <span class="tm-overdue-badge">En retard</span>
                                    @endif
                                </p>
                                @if($task->description)
                                    <p class="tm-task-desc">{{ Str::limit($task->description, 55) }}</p>
                                @endif
                            </div>
                        </div>
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

                    <td>
                        @if($task->due_date)
                            <div class="tm-due-date {{ $task->isOverdue() ? 'tm-due-overdue' : ($task->daysLeft() <= 2 ? 'tm-due-soon' : 'tm-due-ok') }}">
                                <span>@if($task->isOverdue()) ⚠ @elseif($task->daysLeft() <= 2) ⏰ @else 📅 @endif</span>
                                <div>
                                    <span class="tm-due-date-text">{{ $task->due_date->format('d/m/Y') }}</span>
                                    <span class="tm-due-label">
                                        @if($task->isOverdue()) {{ abs($task->daysLeft()) }}j de retard
                                        @elseif($task->daysLeft() == 0) Aujourd'hui
                                        @elseif($task->daysLeft() == 1) Demain
                                        @else Dans {{ $task->daysLeft() }}j
                                        @endif
                                    </span>
                                </div>
                            </div>
                        @else
                            <span class="tm-due-none">—</span>
                        @endif
                    </td>

                    <td>
                        <div class="tm-actions">
                            {{-- Bouton Voir --}}
                            <button type="button"
                                class="tm-icon-btn tm-icon-btn-view"
                                title="Voir le détail"
                                onclick="openModal(
                                    '{{ addslashes($task->title) }}',
                                    '{{ addslashes($task->description ?? 'Aucune description') }}',
                                    '{{ $task->status }}',
                                    '{{ match($task->status) { 'todo' => 'À faire', 'in_progress' => 'En cours', 'done' => 'Terminé', default => $task->status } }}',
                                    '{{ $task->category->name ?? '—' }}',
                                    '{{ $task->due_date ? $task->due_date->format('d/m/Y') : '' }}',
                                    '{{ $task->created_at->format('d/m/Y') }}'
                                )">
                                👁
                            </button>

                            {{-- Bouton Modifier --}}
                            <a href="{{ route('tasks.edit', $task) }}"
                               class="tm-icon-btn" title="Modifier">✎</a>

                            {{-- Bouton Supprimer --}}
                            <form method="POST" action="{{ route('tasks.destroy', $task) }}"
                                  onsubmit="return confirm('Supprimer cette tâche ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="tm-icon-btn tm-icon-btn-danger"
                                    title="Supprimer">✕</button>
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

{{-- ══ MODAL DÉTAIL TÂCHE ══ --}}
<div id="tm-modal-overlay" class="tm-modal-overlay" onclick="closeModal()">
    <div class="tm-modal" onclick="event.stopPropagation()">

        <div class="tm-modal-header">
            <div>
                <span id="modal-category" class="tm-task-card-badge"></span>
                <h2 id="modal-title" class="tm-modal-title"></h2>
            </div>
            <button class="tm-modal-close" onclick="closeModal()">✕</button>
        </div>

        <div class="tm-modal-body">

            <div class="tm-modal-section">
                <p class="tm-modal-label">Description</p>
                <div class="tm-modal-content-box">
                    <p id="modal-description"></p>
                </div>
            </div>

            <div class="tm-modal-meta">
                <div class="tm-modal-meta-item">
                    <span class="tm-modal-label">Statut</span>
                    <span id="modal-status-badge"></span>
                </div>
                <div class="tm-modal-meta-item">
                    <span class="tm-modal-label">Échéance</span>
                    <span id="modal-due" class="tm-modal-meta-value"></span>
                </div>
                <div class="tm-modal-meta-item">
                    <span class="tm-modal-label">Créée le</span>
                    <span id="modal-created" class="tm-modal-meta-value"></span>
                </div>
            </div>

        </div>

        <div class="tm-modal-footer">
            <button class="tm-btn tm-btn-ghost" onclick="closeModal()">Fermer</button>
        </div>

    </div>
</div>

<script>
function openModal(title, description, status, statusLabel, category, dueDate, createdAt) {
    document.getElementById('modal-title').textContent       = title;
    document.getElementById('modal-description').textContent = description;
    document.getElementById('modal-category').textContent    = category;
    document.getElementById('modal-due').textContent         = dueDate || '—';
    document.getElementById('modal-created').textContent     = createdAt;

    // Badge statut
    const badge = document.getElementById('modal-status-badge');
    badge.textContent = statusLabel;
    badge.className   = 'tm-badge tm-badge-' + status;

    // Afficher overlay
    document.getElementById('tm-modal-overlay').classList.add('tm-modal-open');
    document.body.style.overflow = 'hidden';
}

function closeModal() {
    document.getElementById('tm-modal-overlay').classList.remove('tm-modal-open');
    document.body.style.overflow = '';
}

// Fermer avec Escape
document.addEventListener('keydown', e => {
    if (e.key === 'Escape') closeModal();
});
</script>

@endsection