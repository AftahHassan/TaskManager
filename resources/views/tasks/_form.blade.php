{{-- 
    Formulaire réutilisable create / edit
    Variables : $action, $method, $task (optionnel), $categories
--}}

<form method="POST" action="{{ $action }}" class="tm-form">
    @csrf
    @if($method === 'PUT')
        @method('PUT')
    @endif

    {{-- TITRE --}}
    <div class="tm-form-group">
        <label class="tm-label" for="title">Titre <span class="tm-required">*</span></label>
        <input
            type="text"
            id="title"
            name="title"
            class="tm-input @error('title') tm-input-error @enderror"
            value="{{ old('title', $task->title ?? '') }}"
            placeholder="Ex: Préparer la présentation..."
            required
        />
        @error('title')
            <span class="tm-error-msg">{{ $message }}</span>
        @enderror
    </div>

    {{-- DESCRIPTION --}}
    <div class="tm-form-group">
        <label class="tm-label" for="description">Description</label>
        <textarea
            id="description"
            name="description"
            class="tm-textarea @error('description') tm-input-error @enderror"
            placeholder="Détails de la tâche..."
            rows="4"
        >{{ old('description', $task->description ?? '') }}</textarea>
        @error('description')
            <span class="tm-error-msg">{{ $message }}</span>
        @enderror
    </div>

    {{-- STATUT + CATÉGORIE --}}
    <div class="tm-form-row">
        <div class="tm-form-group">
            <label class="tm-label" for="status">Statut <span class="tm-required">*</span></label>
            <select id="status" name="status"
                    class="tm-select @error('status') tm-input-error @enderror">
                <option value="">— Choisir —</option>
                <option value="todo"
                    {{ old('status', $task->status ?? '') === 'todo' ? 'selected' : '' }}>
                    À faire
                </option>
                <option value="in_progress"
                    {{ old('status', $task->status ?? '') === 'in_progress' ? 'selected' : '' }}>
                    En cours
                </option>
                <option value="done"
                    {{ old('status', $task->status ?? '') === 'done' ? 'selected' : '' }}>
                    Terminé
                </option>
            </select>
            @error('status')
                <span class="tm-error-msg">{{ $message }}</span>
            @enderror
        </div>

        <div class="tm-form-group">
            <label class="tm-label" for="category_id">Catégorie <span class="tm-required">*</span></label>
            <select id="category_id" name="category_id"
                    class="tm-select @error('category_id') tm-input-error @enderror">
                <option value="">— Choisir —</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}"
                        {{ old('category_id', $task->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <span class="tm-error-msg">{{ $message }}</span>
            @enderror
        </div>
    </div>

    {{-- DATE D'ÉCHÉANCE --}}
    <div class="tm-form-group">
        <label class="tm-label" for="due_date">
            Date d'échéance
            <span class="tm-label-hint">(optionnelle)</span>
        </label>
        <input
            type="date"
            id="due_date"
            name="due_date"
            class="tm-input @error('due_date') tm-input-error @enderror"
            value="{{ old('due_date', isset($task) && $task->due_date ? $task->due_date->format('Y-m-d') : '') }}"
            min="{{ now()->format('Y-m-d') }}"
        />
        @error('due_date')
            <span class="tm-error-msg">{{ $message }}</span>
        @enderror
    </div>

    {{-- ACTIONS --}}
    <div class="tm-form-actions">
        <a href="{{ route('tasks.index') }}" class="tm-btn tm-btn-ghost">Annuler</a>
        <button type="submit" class="tm-btn tm-btn-primary">
            {{ $method === 'PUT' ? '✎ Mettre à jour' : '⊕ Créer la tâche' }}
        </button>
    </div>

</form>