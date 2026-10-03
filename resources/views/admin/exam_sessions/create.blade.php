@extends('adminlte::page')

@section('title', 'Créer une session d’examen')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
@stop

@section('content_header')
<div class="card-left-success card-header bg-light">
    <h3 class="m-0 text-success">
        <i class="fas fa-calendar-plus me-2"></i> Nouvelle session d’examen
        <a href="{{ route('admin.exam_sessions.index') }}" class="btn btn-outline-danger float-end">
            <i class="fas fa-arrow-left me-1"></i> Retour à la liste
        </a>
    </h3>
</div>
@stop

@section('content')

<div class="card card-left-success shadow border-start border-success border-4">
    <div class="card-body">

        <form action="{{ route('admin.exam_sessions.store') }}" method="POST">
            @csrf

            {{-- Nom session --}}
            <div class="mb-3">
                <label class="form-label">Nom de la session *</label>
                <input type="text" name="name" class="form-control"
                    value="{{ old('name') }}" required>
                @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>

            {{-- Année académique --}}
            <div class="mb-3">
                <label class="form-label">Année académique</label>
                <input type="text" name="academic_year" class="form-control"
                    placeholder="Ex : 2024-2025"
                    value="{{ old('academic_year') }}">
                @error('academic_year') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>

            {{-- Type --}}
            <div class="mb-3">
                <label class="form-label">Type de session</label>
                <select name="type" class="form-control form-select">
                    <option value="">-- Choisir --</option>
                    <option value="normale" {{ old('type')=='normal' ? 'selected' : '' }}>Normale</option>
                    <option value="rattrapage" {{ old('type')=='rattrapage' ? 'selected' : '' }}>Rattrapage</option>
                </select>
                @error('type') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>

            {{-- Dates --}}
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Date début *</label>
                    <input type="date" name="start_date" class="form-control"
                        value="{{ old('start_date') }}" required>
                    @error('start_date') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Date fin *</label>
                    <input type="date" name="end_date" class="form-control"
                        value="{{ old('end_date') }}" required>
                    @error('end_date') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>
            </div>

            {{-- Centre --}}
            <div class="mb-3">
                <label class="form-label">Centre *</label>
                <select name="centre_id" class="form-control form-select" required>
                    <option value="">-- Sélectionner un centre --</option>
                    @foreach($centres as $centre)
                        <option value="{{ $centre->id }}"
                            {{ old('centre_id') == $centre->id ? 'selected' : '' }}>
                            {{ $centre->name }}
                        </option>
                    @endforeach
                </select>
                @error('centre_id') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>

            {{-- Examen --}}
            <div class="mb-3">
                <label class="form-label">Examen associé *</label>
                <select name="exam_id" class="form-control form-select" required>
                    <option value="">-- Choisir un examen --</option>
                    @foreach($exams as $exam)
                        <option value="{{ $exam->id }}"
                            {{ old('exam_id') == $exam->id ? 'selected' : '' }}>
                            {{ $exam->title }} ({{ $exam->code }})
                        </option>
                    @endforeach
                </select>
                @error('exam_id') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>

            {{-- Settings JSON --}}
            <div class="mb-3">
                <label class="form-label">Paramètres (JSON)</label>
                <textarea name="settings" class="form-control" rows="3"
                    placeholder='{"exemple": "valeur"}'>{{ old('settings') }}</textarea>
                @error('settings') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>

            {{-- Boutons --}}
            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('admin.exam_sessions.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Retour
                </a>

                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save me-1"></i> Enregistrer
                </button>
            </div>

        </form>

    </div>
</div>

@stop
