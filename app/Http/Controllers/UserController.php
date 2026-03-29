<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    // Appliquer middleware auth + admin si nécessaire
    
    /**
     * Afficher la liste des utilisateurs.
     */
    public function index()
    {
        $users = User::paginate(10);; // récupère tous les utilisateurs
        return view('users.index', compact('users'));
    }

    /**
     * Afficher le formulaire pour créer un nouvel utilisateur.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Enregistrer un nouvel utilisateur.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed', // le champ password_confirmation doit exister dans le form
            'is_admin' => 'nullable|boolean',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'is_admin' => $validated['is_admin'] ?? false,
        ]);

        return redirect()->route('users.index')->with('success', 'Utilisateur créé avec succès.');
    }

    /**
     * Afficher un utilisateur spécifique.
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * Afficher le formulaire pour éditer un utilisateur.
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Mettre à jour un utilisateur.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required','email', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'is_admin' => 'nullable|boolean',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->is_admin = $validated['is_admin'] ?? $user->is_admin;

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'Utilisateur mis à jour avec succès.');
    }

    /**
     * Supprimer un utilisateur.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Utilisateur supprimé avec succès.');
    }
}