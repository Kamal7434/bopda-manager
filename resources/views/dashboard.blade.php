@extends('layouts.app')

@section('title', 'Tableau de Bord')

@section('content')
<div class="container-fluid">
    <!-- Header avec Titre et Actions Rapides -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark">Aperçu de l'Académie</h2>
            <p class="text-muted small">Statistiques en temps réel et activités récentes.</p>
        </div>
        <div>
            <a href="{{ route('students.create') }}" class="btn btn-primary shadow-sm px-7">
                Inscrire un Étudiant
            </a>
        </div>
    </div>

    <!-- Cartes de Statistiques -->
    <div class="row g-4 mb-4">
        <!-- Carte Utilisateurs -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted fw-normal text-uppercase small">Administrateurs</h6>
                            <h4 class="fw-bold mb-0">{{ $usersCount }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Carte Programmes -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted fw-normal text-uppercase small">Filières / Progs</h6>
                            <h4 class="fw-bold mb-0">{{ $programsCount }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Carte Étudiants -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted fw-normal text-uppercase small">Total Étudiants</h6>
                            <h4 class="fw-bold mb-0">{{ $studentsCount }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Carte Taux de Croissance (Exemple visuel) -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted fw-normal text-uppercase small">Croissance</h6>
                            <h4 class="fw-bold mb-0 text-success">+15%</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <!-- Graphique des inscriptions -->
        <div class="col-12 col-lg-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="card-title fw-bold mb-0">Inscriptions par mois</h5>
                </div>
                <div class="card-body">
                    <canvas id="studentsChart" style="max-height: 300px;"></canvas>
                </div>
            </div>
        </div>

        <!-- Section "Dernières Activités" -->
        <div class="col-12 col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="card-title fw-bold mb-0">Récemment inscrits</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        {{-- On boucle sur les 5 derniers étudiants --}}
                        @forelse($recentStudents ?? [] as $student)
                        <div class="list-group-item border-0 border-bottom py-3">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 bg-light rounded-circle p-2 me-3">
                                    <i class="bi bi-person-fill text-secondary"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between">
                                        <p class="mb-0 fw-bold small text-dark">{{ $student->firstname }} {{ $student->lastname }}</p>
                                        <span class="text-muted x-small">{{ $student->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="text-muted small mb-0">{{ $student->program->name ?? 'Filière inconnue' }}</p>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="p-4 text-center text-muted italic">Aucune donnée disponible.</div>
                        @endforelse
                    </div>
                </div>
                <div class="card-footer bg-white border-0 text-center py-3">
                    <a href="{{ route('students.index') }}" class="text-decoration-none small fw-bold">Voir tous les étudiants</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('studentsChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($months ?? []),
            datasets: [{
                label: 'Étudiants inscrits',
                data: @json($studentsPerMonth ?? []),
                borderColor: '#0d6efd',
                backgroundColor: 'rgba(13, 110, 253, 0.1)',
                fill: true,
                tension: 0.4,
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true, grid: { borderDash: [2, 2] } },
                x: { grid: { display: false } }
            }
        }
    });
</script>
@endsection