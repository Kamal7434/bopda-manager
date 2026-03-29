@extends('layouts.app')

@section('title', 'Gestion des Administrateurs')

@section('content')
<div class="container-fluid">
    <!-- Header de page -->
    <div class="row align-items-center mb-4">
        <div class="col">
            <h2 class="fw-bold text-dark mb-1">Équipe Administrative</h2>
            <p class="text-muted small mb-0">Gestion des accès au panel Bopda Manager.</p>
        </div>
        <div class="col-auto">
            <a href="{{ route('users.create') }}" class="btn btn-primary shadow-sm px-4">Nouvel Admin
            </a>
        </div>
    </div>

    <!-- Carte principale -->
    <div class="card border-0 shadow-sm overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 text-uppercase small fw-bold text-muted" style="width: 40%;">Administrateur</th>
                        <th class="py-3 text-uppercase small fw-bold text-muted">Rôle & Accès</th>
                        <th class="py-3 text-uppercase small fw-bold text-muted text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    @forelse($users as $user)
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center">
                                <!-- Avatar stylisé avec dégradé -->
                                <div class="admin-avatar me-3">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-bold text-dark d-flex align-items-center">
                                        {{ $user->name }}
                                        @if($user->id === Auth::id())
                                            <span class="badge bg-primary-subtle text-primary ms-2 x-small border border-primary-subtle">C'est vous</span>
                                        @endif
                                    </div>
                                    <div class="text-muted x-small italic">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <span class="badge bg-dark-subtle text-dark border px-2 py-1 small fw-medium">
                                    <i class="bi bi-shield-lock me-1"></i> Administrateur
                                </span>
                                <span class="ms-3 text-muted x-small">
                                    Inscrit le {{ $user->created_at->format('d/m/Y') }}
                                </span>
                            </div>
                        </td>
                        <td class="text-end pe-4">
                            <div class="btn-group">
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-outline-warning border-0" title="Modifier">
                                    <i class="bi bi-pencil-square fs-5"></i>
                                </a>
                                
                                {{-- Empêcher l'auto-suppression pour plus de sécurité --}}
                                @if($user->id !== Auth::id())
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger border-0" 
                                            onclick="return confirm('Supprimer définitivement cet accès administrateur ?')" 
                                            title="Supprimer">
                                        <i class="bi bi-trash3-fill fs-5"></i>
                                    </button>
                                </form>
                                @else
                                <button class="btn btn-sm btn-outline-secondary border-0 disabled" title="Vous ne pouvez pas vous supprimer">
                                    <i class="bi bi-slash-circle fs-5"></i>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center py-5 text-muted">
                            <i class="bi bi-person-exclamation fs-1 d-block mb-3 opacity-25"></i>
                            Aucun administrateur trouvé.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($users->hasPages())
        <div class="card-footer bg-white py-3 border-top">
            <div class="d-flex justify-content-center">
                {{ $users->links('pagination::bootstrap-5') }}
            </div>
        </div>
        @endif
    </div>
</div>

<style>
    /* Avatar Admin spécifique */
    .admin-avatar {
        width: 42px;
        height: 42px;
        background: linear-gradient(135deg, #4361ee 0%, #3f37c9 100%);
        color: #fff;
        border-radius: 12px; /* Un peu plus carré pour différencier des étudiants */
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        box-shadow: 0 4px 6px rgba(67, 97, 238, 0.15);
    }

    .x-small { font-size: 0.75rem; }
    
    /* Couleurs Subtile (Bootstrap 5.3+) */
    .bg-primary-subtle { background-color: rgba(67, 97, 238, 0.1) !important; }
    .bg-dark-subtle { background-color: #f1f1f1 !important; }

    /* Hover effect */
    tbody tr { transition: all 0.2s; }
    tbody tr:hover { background-color: rgba(0, 0, 0, 0.01) !important; }
</style>
@endsection