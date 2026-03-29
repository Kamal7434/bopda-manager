@extends('layouts.app')
@section('title','Modifier Admin')
@section('content')
<div class="mb-3">
    <h2>Modifier l'admin</h2>
</div>

<form action="{{ route('users.update', $user->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="name" class="form-label">Nom</label>
        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}">
        @error('name')<small class="text-danger">{{ $message }}</small>@enderror
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}">
        @error('email')<small class="text-danger">{{ $message }}</small>@enderror
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Mot de passe (laisser vide pour conserver)</label>
        <input type="password" name="password" id="password" class="form-control">
        @error('password')<small class="text-danger">{{ $message }}</small>@enderror
    </div>

    <div class="mb-3">
        <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
    </div>

    <button type="submit" class="btn btn-primary shadow-sm px-4">Modifier
    </button>
    <a href="{{ route('users.index') }}" class="btn btn-secondary">Annuler
    </a>
</form>
@endsection