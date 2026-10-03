@extends('adminlte::page')

@section('title', 'Modifier une session d’examen')

@section('css')
<link rel="stylesheet" href="{{ asset('css/custom.css') }}">
@stop

@section('content_header')
<div class="card-left-success card-header bg-light">
    <h3 class="m-0 text-success">
        <i class="fas fa-calendar-edit me-2"></i> Modifier la session d’examen
        <a href="{{ route('admin.exam_sessions.index') }}" class="btn btn-outline-danger float-end">
            <i class="fas fa-arrow-left me-1"></i> Retour à la liste
        </a>
    </h3>
</div>
@stop

@section('content')
<div class="card card-left-success shadow border-start border-success border-4">
    <div class="card-body">

        <form action="{{ route('admin.exam_sessions.update', $session) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Nom --}}
            <div class="mb-3">
                <label class="form-label">Nom de la session <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $session->name) }}" required>
                @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>

            {{-- Année académique --}}
            <div class="mb-3">
                <label class="form-label">Année académique <span class="text-danger">*</span></label>
                <input type="text" name="academic_year" class="form-control" 
                    value="{{ old('academic_year', $session->academic_year) }}" required>
                @error('academic_year') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>

            {{-- Type --}}
            <div class="mb-3">
                <label class="form-label">Type de session <span class="text-danger">*</span></label>
                <select name="type" class="form-select form-control" required>
                    <option value="initial" {{ old('type', $session->type) == 'initial' ? 'selected' : '' }}>Initial</option>
                    <option value="rattrapage" {{ old('type', $session->type) == 'rattrapage' ? 'selected' : '' }}>Rattrapage</option>
                </select>
                @error('type') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>

            {{-- Date début --}}
            <div class="mb-3">
                <label class="form-label">Date de début <span class="text-danger">*</span></label>
                <input type="date" name="start_date" class="form-control" 
                    value="{{ old('start_date', $session->start_date->format('Y-m-d')) }}" required>
                @error('start_date') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>

            {{-- Date fin --}}
            <div class="mb-3">
                <label class="form-label">Date de fin <span class="text-danger">*</span></label>
                <input type="date" name="end_date" class="form-control" 
                    value="{{ old('end_date', $session->end_date->format('Y-m-d')) }}" required>
                @error('end_date') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>

            {{-- Centre --}}
            <div class="mb-3">
                <label class="form-label">Centre <span class="text-danger">*</span></label>
                <select name="centre_id" class="form-select form-control" required>
                    <option value="">-- Sélectionner un centre --</option>
                    @foreach($centres as $centre)
                        <option value="{{ $centre->id }}" {{ old('centre_id', $session->centre_id) == $centre->id ? 'selected' : '' }}>
                            {{ $centre->name }}
                        </option>
                    @endforeach
                </select>
                @error('centre_id') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>

            {{-- Examen associé --}}
            <div class="mb-3">
                <label class="form-label">Examen associé <span class="text-danger">*</span></label>
                <select name="exam_id" class="form-select form-control" required>
                    <option value="">-- Choisir un examen --</option>
                    @foreach($exams as $exam)
                        <option value="{{ $exam->id }}" {{ old('exam_id', $session->exam_id) == $exam->id ? 'selected' : '' }}>
                            {{ $exam->title }} ({{ $exam->code }})
                        </option>
                    @endforeach
                </select>
                @error('exam_id') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>

            {{-- Boutons --}}
            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('admin.exam_sessions.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Retour
                </a>
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save me-1"></i> Mettre à jour
                </button>
            </div>

        </form>

    </div>
</div>
@stop
