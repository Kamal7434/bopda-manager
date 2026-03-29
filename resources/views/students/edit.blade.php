@extends('layouts.app')
@section('title','Modifier Étudiant')
@section('content')
<div class="mb-3">
    <h2>Modifier l'étudiant</h2>
</div>

<form action="{{ route('students.update', $student->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="name" class="form-label">Nom</label>
        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $student->name) }}">
        @error('name')<small class="text-danger">{{ $message }}</small>@enderror
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $student->email) }}">
        @error('email')<small class="text-danger">{{ $message }}</small>@enderror
    </div>

    <div class="mb-3">
        <label for="phone" class="form-label">Téléphone</label>
        <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $student->phone) }}">
        @error('phone')<small class="text-danger">{{ $message }}</small>@enderror
    </div>

    <div class="mb-3">
        <label for="program_id" class="form-label">Filière</label>
        <select name="program_id" id="program_id" class="form-select">
            @foreach($programs as $program)
                <option value="{{ $program->id }}" {{ $student->program_id==$program->id?'selected':'' }}>{{ $program->name }}</option>
            @endforeach
        </select>
        @error('program_id')<small class="text-danger">{{ $message }}</small>@enderror
    </div>

    <button type="submit" class="btn btn-primary shadow-sm"></i> Modifier</button>
    <a href="{{ route('students.index') }}" class="btn btn-secondary"> Annuler</a>
</form>
@endsection