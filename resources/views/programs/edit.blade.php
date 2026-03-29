@extends('layouts.app')
@section('title','Modifier Filière')
@section('content')
<div class="mb-3">
    <h2>Modifier la filière</h2>
</div>

<form action="{{ route('programs.update', $program->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="name" class="form-label">Nom de la filière</label>
        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $program->name) }}">
        @error('name')<small class="text-danger">{{ $message }}</small>@enderror
    </div>

    <button type="submit" class="btn btn-primary shadow-sm px-4">Modifier
    </button>
    <a href="{{ route('programs.index') }}" class="btn btn-secondary"> Annuler
    </a>
</form>
@endsection