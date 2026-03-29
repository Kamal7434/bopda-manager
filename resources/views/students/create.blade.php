@extends('layouts.app')
@section('title','Ajouter Étudiant')
@section('content')
<div class="mb-3">
    <h2>Ajouter un étudiant</h2>
</div>

<form action="{{ route('students.store') }}" method="POST">
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
        <label for="phone" class="form-label">Téléphone</label>
        <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone') }}">
        @error('phone')<small class="text-danger">{{ $message }}</small>@enderror
    </div>

    <div class="mb-3">
        <label for="program_id" class="form-label">Filière</label>
        <select name="program_id" id="program_id" class="form-select">
            <option value="">-- Sélectionner une filière --</option>
            @foreach($programs as $program)
                <option value="{{ $program->id }}" {{ old('program_id')==$program->id?'selected':'' }}>{{ $program->name }}</option>
            @endforeach
        </select>
        @error('program_id')<small class="text-danger">{{ $message }}</small>@enderror
    </div>

    <button type="submit" class="btn btn-primary shadow-sm"> Créer</button>
    <a href="{{ route('students.index') }}" class="btn btn-secondary"> Annuler</a>
</form>
@endsection