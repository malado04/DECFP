@extends('adminlte::page')

@section('title', 'Créer un candidat')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
@stop

@section('content_header')
<div class="card card-left-success card-header bg-light border-start border-success border-4 mb-3">
    <h3 class="m-0 text-success">
        <i class="fas fa-user-plus me-2"></i> Ajouter un candidat
        <a href="{{ route('admin.candidates.index') }}" class="btn btn-outline-danger float-end">
            <i class="fas fa-arrow-left me-1"></i> Retour
        </a>
    </h3>
</div>
@stop

@section('content')

<div class="card shadow border-start border-success border-4">
    <div class="card-body">
        <form action="{{ route('admin.candidates.store') }}" method="POST">
            @csrf

            {{-- ================================================= --}}
            {{-- IDENTIFIANTS ADMINISTRATIFS --}}
            {{-- ================================================= --}}
            <div class="section-card mb-4">
                <h4 class="text-success"><i class="fas fa-id-card me-2"></i> Identifiants administratifs</h4>
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label class="form-label">N° ANO</label>
                        <input type="text" name="ano_number" class="form-control" value="{{ old('ano_number') }}">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">N° ANO 2</label>
                        <input type="text" name="ano_number_2" class="form-control" value="{{ old('ano_number_2') }}">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">N° Inscription</label>
                        <input type="text" name="registration_number" class="form-control" value="{{ old('registration_number') }}">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">N° Base</label>
                        <input type="text" name="n_base" class="form-control" value="{{ old('n_base') }}">
                    </div>
                </div>
            </div>

            {{-- ================================================= --}}
            {{-- INFORMATIONS PERSONNELLES --}}
            {{-- ================================================= --}}
            <div class="section-card mb-4">
                <h4 class="text-success"><i class="fas fa-user me-2"></i> Informations personnelles</h4>
                <div class="row">

                    <div class="col-md-3 mb-3">
                        <label class="form-label">N° Identité nationale</label>
                        <input type="text" name="national_id" class="form-control" value="{{ old('national_id') }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Prénom <span class="text-danger">*</span></label>
                        <input type="text" name="first_name" class="form-control" value="{{ old('first_name') }}" required>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">Nom <span class="text-danger">*</span></label>
                        <input type="text" name="last_name" class="form-control" value="{{ old('last_name') }}" required>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">Sexe</label>
                        <select name="sex" class="form-select form-control">
                            <option value="">-- Choisir --</option>
                            <option value="M" {{ old('sex')=='M'?'selected':'' }}>Masculin</option>
                            <option value="F" {{ old('sex')=='F'?'selected':'' }}>Féminin</option>
                        </select>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">Date de naissance</label>
                        <input type="date" name="birthdate" class="form-control" value="{{ old('birthdate') }}">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">Lieu de naissance</label>
                        <input type="text" name="birth_place" class="form-control" value="{{ old('birth_place') }}">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">Téléphone</label>
                        <input type="text" name="tel" class="form-control" value="{{ old('tel') }}">
                    </div>


                </div>
            </div>

            {{-- ================================================= --}}
            {{-- HISTORIQUE ACADÉMIQUE --}}
            {{-- ================================================= --}}
            <div class="section-card mb-4">
                <h4 class="text-success"><i class="fas fa-graduation-cap me-2"></i> Historique académique</h4>
                <div class="row">

               <!--      <div class="col-md-4 mb-3">
                        <label class="form-label">Admis en 2016</label>
                        <select name="admission_2016" class="form-select">
                            <option value="">-- Sélectionner --</option>
                            <option value="1" {{ old('admission_2016')==='1'?'selected':'' }}>Oui</option>
                            <option value="0" {{ old('admission_2016')==='0'?'selected':'' }}>Non</option>
                        </select>
                    </div> -->

                    <div class="col-md-8 mb-3">
                        <label class="form-label">Provenance</label>
                        <input type="text" name="provenance" class="form-control"
                               placeholder="Établissement ou région d'origine"
                               value="{{ old('provenance') }}">
                    </div>

                </div>
            </div>

            {{-- ================================================= --}}
            {{-- INFORMATIONS EXAMEN --}}
            {{-- ================================================= --}}
            <div class="section-card mb-4">
                <h4 class="text-success"><i class="fas fa-school me-2"></i> Informations examen</h4>
                <div class="row">

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Centre <span class="text-danger">*</span></label>
                        <select name="centre_id"  class="form-select form-control"required>
                            <option value="">-- Sélectionner --</option>
                            @foreach($centres as $centre)
                                <option value="{{ $centre->id }}" {{ old('centre_id')==$centre->id?'selected':'' }}>
                                    {{ $centre->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Examen <span class="text-danger">*</span></label>
                        <select name="exam_id"  class="form-select form-control"required>
                            <option value="">-- Sélectionner --</option>
                            @foreach($exams as $exam)
                                <option value="{{ $exam->id }}" {{ old('exam_id')==$exam->id?'selected':'' }}>
                                    {{ $exam->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Session <span class="text-danger">*</span></label>
                        <select name="exam_session_id"  class="form-select form-control"required>
                            <option value="">-- Sélectionner --</option>
                            @foreach($sessions as $session)
                                <option value="{{ $session->id }}" {{ old('exam_session_id')==$session->id?'selected':'' }}>
                                    {{ $session->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Statut</label>
                        <select name="status" class="form-select form-control">
                            @foreach(['inscrit','admis','ajourné','absent'] as $status)
                                <option value="{{ $status }}" {{ old('status')==$status?'selected':'' }}>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                </div>
            </div>

            {{-- ================================================= --}}
            {{-- BOUTONS --}}
            {{-- ================================================= --}}
            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.candidates.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Annuler
                </a>
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save me-1"></i> Enregistrer le candidat
                </button>
            </div>

        </form>
    </div>
</div>

@stop
