<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Note;
use App\Models\Category;

class AdminNoteController extends Controller
{
    public function index()
    {
        $notes = Note::with(['user', 'category'])->latest()->paginate(10);
        return view('admin.notes.index', compact('notes'));
    }

    public function create()
    {
        $categories = Category::all();
        $notes = Note::all();
        return view('admin.notes.create', compact('categories', 'notes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'category_id' => 'required|exists:categories,id',
            'parent_id' => 'nullable|exists:notes,id'
        ]);

        $validated['user_id'] = Auth::id();
        Note::create($validated);

        return redirect()->route('admin.notes.index')->with('success', '筆記已成功創建');
    }
}
