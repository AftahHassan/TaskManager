<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Category;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // 🔹 1. Liste des tâches + filtres
    public function index(Request $request)
    {
        $query = Task::where('user_id', auth()->id())
                     ->with('category');

        // Filtre par statut
        if ($request->status) {
            $query->where('status', $request->status);
        }

        // Filtre par catégorie
        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        $tasks = $query->latest()->paginate(8);
        $categories = Category::all();

        return view('tasks.index', compact('tasks', 'categories'));
    }

    // 🔹 2. Formulaire création
    public function create()
    {
        $categories = Category::all();
        return view('tasks.create', compact('categories'));
    }

    // 🔹 3. Enregistrer tâche
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        $data['user_id'] = auth()->id();

        Task::create($data);

        return redirect()->route('tasks.index')
                         ->with('success', 'Tâche créée avec succès');
    }

    // 🔹 4. Modifier (formulaire)
    public function edit(Task $task)
    {
        // 🔐 sécurité
        if ($task->user_id !== auth()->id()) {
            abort(403);
        }

        $categories = Category::all();

        return view('tasks.edit', compact('task', 'categories'));
    }

    // 🔹 5. Mettre à jour
    public function update(Request $request, Task $task)
    {
        if ($task->user_id !== auth()->id()) {
            abort(403);
        }

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        $task->update($data);

        return redirect()->route('tasks.index')
                         ->with('success', 'Tâche mise à jour');
    }

    // 🔹 6. Supprimer
    public function destroy(Task $task)
    {
        if ($task->user_id !== auth()->id()) {
            abort(403);
        }

        $task->delete();

        return redirect()->route('tasks.index')
                         ->with('success', 'Tâche supprimée');
    }
}