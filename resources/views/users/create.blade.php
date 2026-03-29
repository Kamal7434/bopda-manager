@extends('layouts.app')
@section('title','Ajouter Admin')
@section('content')
<div class="mb-3">
    <h2>Ajouter un admin</h2>
</div>

<form action="{{ route('users.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label for="name" class="form-label">Nom</label>
        <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
        @error('name')<small class="text-danger">{{ $message }}</small>@enderror
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}">
        @error('email')<small class="text-danger">{{ $message }}</small>@enderror
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Mot de passe</label>
        <input type="password" name="password" id="password" class="form-control">
        @error('password')<small class="text-danger">{{ $message }}</small>@enderror
    </div>

    <div class="mb-3">
        <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
    </div>

    <button type="submit" class="btn btn-primary shadow-sm px-4">Créer
    </button>
    <a href="{{ route('users.index') }}" class="btn btn-secondary">Annuler
    </a>
</form>
@endsection