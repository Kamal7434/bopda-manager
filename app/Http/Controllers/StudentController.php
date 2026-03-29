<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Program;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        // On commence une requête sur le modèle Student
        $query = Student::with('program');

        // FILTRE PAR RECHERCHE (Nom ou Email)
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // FILTRE PAR FILIÈRE (Si l'utilisateur choisit une filière précise)
        if ($request->has('program_id') && $request->program_id != '') {
            $query->where('program_id', $request->program_id);
        }

        // On récupère les résultats paginés en gardant les filtres dans l'URL
        $students = $query->latest()->paginate(10)->withQueryString();
        
        // On récupère aussi la liste des programmes pour le menu déroulant du filtre
        $programs = Program::all();

        return view('students.index', compact('students', 'programs'));
    }

    public function create()
    {
        $programs = Program::all();
        return view('students.create', compact('programs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'=>'required|string|max:255',
            'email'=>'required|email|unique:students,email',
            'phone'=>'nullable|string|max:20',
            'program_id'=>'required|exists:programs,id',
        ]);

        Student::create($validated);
        return redirect()->route('students.index')->with('success','Étudiant créé avec succès.');
    }

    public function edit(Student $student)
    {
        $programs = Program::all();
        return view('students.edit', compact('student','programs'));
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'name'=>'required|string|max:255',
            'email'=>"required|email|unique:students,email,{$student->id}",
            'phone'=>'nullable|string|max:20',
            'program_id'=>'required|exists:programs,id',
        ]);

        $student->update($validated);
        return redirect()->route('students.index')->with('success','Étudiant modifié avec succès.');
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('students.index')->with('success','Étudiant supprimé avec succès.');
    }
}