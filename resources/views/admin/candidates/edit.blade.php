@extends('adminlte::page')

@section('title', 'Modifier un candidat')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
<style>
    .section-card {
        border-left: 4px solid #28a745;
        padding: 15px;
        margin-bottom: 20px;
        background-color: #f9f9f9;
        border-radius: 6px;
        box-shadow: 0 0 5px rgba(0,0,0,0.05);
    }
    .section-card h4 {
        margin-bottom: 15px;
        font-weight: 600;
        color: #28a745;
    }
</style>
@stop

@section('content_header')
<div class="card-left-success card-header bg-light">
    <h3 class="m-0 text-success">
        <i class="fas fa-user-edit me-2"></i> Modifier le candidat
        <a href="{{ route('admin.candidates.index') }}" class="btn btn-outline-danger float-end">
            <i class="fas fa-arrow-left me-1"></i> Retour
        </a>
    </h3>
</div>
@stop

@section('content')
<div class="card card-left-success shadow border-start border-success border-4">
    <div class="card-body">

        <form action="{{ route('admin.candidates.update', $candidate) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- ---------------- Info personnelles ---------------- --}}
            <div class="section-card">
                <h4>Informations personnelles</h4>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Prénom <span class="text-danger">*</span></label>
                        <input type="text" name="first_name" class="form-control" 
                               value="{{ old('first_name', $candidate->first_name) }}" required>
                        @error('first_name') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nom <span class="text-danger">*</span></label>
                        <input type="text" name="last_name" class="form-control" 
                               value="{{ old('last_name', $candidate->last_name) }}" required>
                        @error('last_name') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Téléphone</label>
                        <input type="text" name="tel" class="form-control" 
                               value="{{ old('tel', $candidate->tel) }}">
                        @error('tel') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">N° Identité nationale</label>
                        <input type="text" name="national_id" class="form-control" 
                               value="{{ old('national_id', $candidate->national_id) }}">
                        @error('national_id') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Sexe</label>
                        <select name="sex" class="form-select form-control">
                            <option value="">-- Choisir --</option>
                            <option value="M" {{ old('sex', $candidate->sex)=='M'?'selected':'' }}>M</option>
                            <option value="F" {{ old('sex', $candidate->sex)=='F'?'selected':'' }}>F</option>
                        </select>
                        @error('sex') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Date de naissance</label>
                        <input type="date" name="birthdate" class="form-control"
                               value="{{ old('birthdate', $candidate->birthdate ? \Carbon\Carbon::parse($candidate->birthdate)->format('Y-m-d') : '') }}">
                        @error('birthdate') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select form-control">
                            <option value="">-- Sélectionner --</option>
                            @foreach(['inscrit','admis','ajourné','absent'] as $status)
                                <option value="{{ $status }}" 
                                    {{ old('status', $candidate->status) == $status ? 'selected' : '' }}>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                        @error('status') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            {{-- ---------------- Info professionnelles ---------------- --}}
            <div class="section-card">
                <h4>Informations professionnelles</h4>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Centre <span class="text-danger">*</span></label>
                        <select name="centre_id" class="form-select form-control" required>
                            <option value="">-- Sélectionner un centre --</option>
                            @foreach($centres as $centre)
                                <option value="{{ $centre->id }}" 
                                    {{ old('centre_id', $candidate->centre_id) == $centre->id ? 'selected' : '' }}>
                                    {{ $centre->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('centre_id') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Examen <span class="text-danger">*</span></label>
                        <select name="exam_id" class="form-select form-control" required>
                            <option value="">-- Sélectionner un examen --</option>
                            @foreach($exams as $exam)
                                <option value="{{ $exam->id }}" 
                                    {{ old('exam_id', $candidate->exam_id) == $exam->id ? 'selected' : '' }}>
                                    {{ $exam->title }}
                                </option>
                            @endforeach
                        </select>
                        @error('exam_id') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Session <span class="text-danger">*</span></label>
                        <select name="exam_session_id" class="form-select form-control" required>
                            <option value="">-- Sélectionner une session --</option>
                            @foreach($sessions as $session)
                                <option value="{{ $session->id }}" 
                                    {{ old('exam_session_id', $candidate->exam_session_id) == $session->id ? 'selected' : '' }}>
                                    {{ $session->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('exam_session_id') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            {{-- ---------------- Boutons ---------------- --}}
            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('admin.candidates.index') }}" class="btn btn-secondary">
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
