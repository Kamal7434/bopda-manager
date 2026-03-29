@extends('layouts.app')

@section('title', 'Gestion des Étudiants')

@section('content')
<div class="container-fluid">
    <!-- Header de page -->
    <div class="row align-items-center mb-4">
        <div class="col">
            <h2 class="fw-bold text-dark mb-1">Liste des Étudiants</h2>
            <p class="text-muted small mb-0">Total : <span class="badge bg-secondary">{{ $students->total() }} étudiants</span></p>
        </div>
        <div class="col-auto">
            <div class="d-flex gap-2">
                <form action="{{ route('students.index') }}" method="GET" class="d-none d-md-flex">
                    <div class="col-12 col-md-5">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 text-muted">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" name="search" class="form-control border-start-0 ps-0" 
                           placeholder="Rechercher par nom ou email..." value="{{ request('search') }}">
                </div>
            </div>

            <!-- Filtre par Filière -->
            <div class="col-12 col-md-4">
                <select name="program_id" class="form-select">
                    <option value="">Toutes les filières</option>
                    @foreach($programs as $program)
                        <option value="{{ $program->id }}" {{ request('program_id') == $program->id ? 'selected' : '' }}>
                            {{ $program->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Boutons -->
            <div class="col-12 col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100">
                    Filtrer
                </button>
                <a href="{{ route('students.index') }}" class="btn btn-outline-secondary w-100">
                    Effacer
                </a>
            </div>
                </form>
                <a href="{{ route('students.create') }}" class="btn btn-primary shadow-sm">Ajouter
                </a>
            </div>
        </div>
    </div>

    <!-- Carte principale -->
    <div class="card border-0 shadow-sm overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 text-uppercase small fw-bold text-muted" style="width: 30%;">Étudiant</th>
                        <th class="py-3 text-uppercase small fw-bold text-muted">Contact</th>
                        <th class="py-3 text-uppercase small fw-bold text-muted">Filière</th>
                        <th class="py-3 text-uppercase small fw-bold text-muted">Date d'inscription</th>
                        <th class="py-3 text-uppercase small fw-bold text-muted text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    @forelse($students as $student)
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center">
                                <!-- Avatar avec initiales -->
                                <div class="avatar-circle me-3">
                                    {{ strtoupper(substr($student->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-bold text-dark">{{ $student->name }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex flex-column">
                                <span class="small"><i class="bi bi-envelope-at me-1 text-muted"></i> {{ $student->email }}</span>
                                <span class="small text-muted"><i class="bi bi-telephone me-1"></i> {{ $student->phone ?? 'Non renseigné' }}</span>
                            </div>
                        </td>
                        <td>
                            <span class="badge rounded-pill bg-info bg-opacity-10 text-info px-3 border border-info border-opacity-10">
                                {{ $student->program->name }}
                            </span>
                        </td>
                        <td class="small text-muted">
                            {{ $student->created_at->format('d/m/Y') }}
                        </td>
                        <td class="text-end pe-4">
                            <div class="btn-group">
                                <a href="{{ route('students.edit', $student->id) }}" class="btn btn-sm btn-outline-warning border-0" title="Modifier">
                                    <i class="bi bi-pencil-square fs-5"></i>
                                </a>
                                <form action="{{ route('students.destroy', $student->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger border-0" 
                                            onclick="return confirm('Supprimer cet étudiant ?')" title="Supprimer">
                                        <i class="bi bi-trash3-fill fs-5"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="bi bi-people fs-1 d-block mb-3 opacity-25"></i>
                            Aucun étudiant trouvé dans la base de données.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($students->hasPages())
        <div class="card-footer bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <span class="small text-muted">Affichage de {{ $students->firstItem() }} à {{ $students->lastItem() }} sur {{ $students->total() }}</span>
                {{ $students->links('pagination::bootstrap-5') }}
            </div>
        </div>
        @endif
    </div>
</div>

<style>
    /* Style local pour les avatars */
    .avatar-circle {
        width: 40px;
        height: 40px;
        background-color: #e9ecef;
        color: #4361ee;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.9rem;
        border: 2px solid #fff;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }

    .x-small { font-size: 0.75rem; }
    
    .btn-white {
        background: #fff;
        color: #6c757d;
    }

    /* Animation au survol des lignes */
    tbody tr { transition: background-color 0.2s; }
    tbody tr:hover { background-color: rgba(67, 97, 238, 0.02) !important; }

    /* Ajustement pagination Bootstrap */
    .pagination { margin-bottom: 0; }
    .page-link { border: none; padding: 8px 16px; margin: 0 2px; border-radius: 8px !important; color: #4361ee; }
    .page-item.active .page-link { background-color: #4361ee; }
</style>
@endsection