@extends('adminlte::page')

@section('title', 'Ajouter un examen')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
@stop

@section('content_header')
<div class="card-left-success card-header bg-light">
    <h3 class="m-0 text-success">
        <i class="fas fa-plus-circle me-2"></i> Ajouter un examen
        <a href="{{ route('admin.exams.index') }}" class="btn btn-outline-danger float-end">
            <i class="fas fa-arrow-left me-1"></i> Retour
        </a>
    </h3>
</div>
@stop

@section('content')
<div class="card card-left-success shadow border-start border-success border-4">
    <div class="card-body bg-light">
        <form action="{{ route('admin.exams.store') }}" method="POST">
            @csrf

           <!--  <div class="mb-3">
                <label for="code" class="form-label">Code de l'examen</label>
                <input type="text" name="code" id="code" class="form-control" value="{{ old('code') }}" required>
                @error('code')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div> -->

            <div class="mb-3">
                <label for="title" class="form-label">Nom de l'examen</label>
                <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required>
                @error('title')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                @error('description')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="centre_id" class="form-label">Centre</label>
                <select name="centre_id" id="centre_id" class="form-select form-control" required>
                    <option value="">Sélectionner un centre</option>
                    @foreach($centres as $centre)
                        <option value="{{ $centre->id }}" @selected(old('centre_id') == $centre->id)>{{ $centre->name }}</option>
                    @endforeach
                </select>
                @error('centre_id')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-success">
                <i class="fas fa-plus-circle me-1"></i> Ajouter l'examen
            </button>
        </form>
    </div>
</div>
@stop
