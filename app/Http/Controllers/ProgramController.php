<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function index()
    {
        $programs = Program::withCount('students')->paginate(10);
        return view('programs.index', compact('programs'));
    }

    public function create()
    {
        return view('programs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        Program::create($request->all());

        return redirect()->route('programs.index')
                         ->with('success', 'Filière ajoutée avec succès');
    }

    public function edit(Program $program)
    {
        return view('programs.edit', compact('program'));
    }

    public function update(Request $request, Program $program)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $program->update($request->all());

        return redirect()->route('programs.index')
                         ->with('success', 'Filière mise à jour');
    }

    public function destroy(Program $program)
    {
        $program->delete();

        return back()->with('success', 'Filière supprimée');
    }
}