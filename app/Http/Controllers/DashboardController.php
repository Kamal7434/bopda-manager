<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Student;
use App\Models\Program;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Statistiques globales
        $usersCount = User::count();
        $studentsCount = Student::count();
        $programsCount = Program::count();

        // 2. Récupération des 5 derniers étudiants avec leur filière (pour éviter les erreurs dans la vue)
        // On utilise eager loading (with('program')) pour la performance
        $recentStudents = Student::with('program')->latest()->take(5)->get();

        // 3. Préparation des données du graphique
        $months = [];
        $studentsPerMonth = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $months[] = $date->translatedFormat('M Y'); // 'translatedFormat' pour avoir "Janv. 2026" au lieu de "Jan 2026"
            
            // On compte les étudiants inscrits durant ce mois et cette année précise
            $count = Student::whereMonth('created_at', $date->month)
                            ->whereYear('created_at', $date->year)
                            ->count();
            
            $studentsPerMonth[] = $count;
        }

        // 4. Retour de la vue avec toutes les variables nécessaires
        return view('dashboard', compact(
            'usersCount', 
            'studentsCount', 
            'programsCount', 
            'months', 
            'studentsPerMonth',
            'recentStudents'
        ));
    }
}