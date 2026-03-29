@extends('layouts.app')

@section('title', 'Gestion des Filières')

@section('content')
<div class="container-fluid">
    <!-- Header de page -->
    <div class="row align-items-center mb-4">
        <div class="col">
            <h2 class="fw-bold text-dark mb-1">Liste des Filières</h2>
            <p class="text-muted small mb-0">Total : <span class="badge bg-secondary">{{ $programs->total() }} filières actives</span></p>
        </div>
        <div class="col-auto">
            <a href="{{ route('programs.create') }}" class="btn btn-primary shadow-sm px-4">Nouvelle Filière
            </a>
        </div>
    </div>

    <!-- Carte principale -->
    <div class="card border-0 shadow-sm overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 text-uppercase small fw-bold text-muted" style="width: 50%;">Nom de la Filière</th>
                        <th class="py-3 text-uppercase small fw-bold text-muted text-center">Effectif</th>
                        <th class="py-3 text-uppercase small fw-bold text-muted text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    @forelse($programs as $program)
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center">
                                <div class="icon-box me-3 bg-primary bg-opacity-10 text-primary">
                                    <i class="bi bi-bookmark-star-fill"></i>
                                </div>
                                <div>
                                    <span class="fw-bold text-dark fs-6">{{ $program->name }}</span>
                                    <div class="text-muted x-small">Créée le {{ $program->created_at->format('d/m/Y') }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            {{-- Si tu as défini la relation dans ton modèle Program, on affiche le compte --}}
                            <span class="badge rounded-pill bg-light text-dark border px-3 py-2">
                                <i class="bi bi-people-fill me-1 text-primary"></i>
                                {{ $program->students_count ?? '0' }} {{ Str::plural('étudiant', $program->students_count ?? 0) }}
                            </span>
                        </td>
                        <td class="text-end pe-4">
                            <div class="btn-group">
                                <a href="{{ route('programs.edit', $program->id) }}" class="btn btn-sm btn-outline-warning border-0" title="Modifier">
                                    <i class="bi bi-pencil-square fs-5"></i>
                                </a>
                                <form action="{{ route('programs.destroy', $program->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger border-0" 
                                            onclick="return confirm('Supprimer cette filière ? Attention, cela peut impacter les étudiants rattachés.')" 
                                            title="Supprimer">
                                        <i class="bi bi-trash3-fill fs-5"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center py-5 text-muted">
                            <i class="bi bi-folder-x fs-1 d-block mb-3 opacity-25"></i>
                            Aucune filière n'a encore été enregistrée.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($programs->hasPages())
        <div class="card-footer bg-white py-3">
            <div class="d-flex justify-content-center">
                {{ $programs->links('pagination::bootstrap-5') }}
            </div>
        </div>
        @endif
    </div>
</div>

<style>
    /* Boîte d'icône stylisée */
    .icon-box {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
    }

    .x-small { font-size: 0.75rem; }

    /* Animation au survol */
    tbody tr { transition: all 0.2s ease; }
    tbody tr:hover { background-color: rgba(67, 97, 238, 0.03) !important; }

    /* Boutons d'action */
    .btn-outline-warning:hover { background-color: #ffc107; color: #fff !important; }
    .btn-outline-danger:hover { background-color: #dc3545; color: #fff !important; }
</style>
@endsection