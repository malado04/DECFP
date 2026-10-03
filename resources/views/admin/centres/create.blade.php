@extends('adminlte::page')

@section('title', 'Ajouter un centre')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center mb-3 ">
        <h1 class="m-0 text-success">
            <i class="fas fa-school me-2"></i> Ajouter un centre d’examen
        </h1>
        <a href="{{ route('admin.centres.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Retour à la liste
        </a>
    </div>
@stop

@section('content')
<div class="card shadow border-start border-success border-4">
    <div class="card-header bg-success text-white">
        <h5 class="mb-0"><i class="fas fa-plus-circle me-2"></i> Informations du centre</h5>
    </div>

    <div class="card-body bg-light">
        <form action="{{ route('admin.centres.store') }}" method="POST">
            @csrf

            <!-- Nom -->
            <div class="mb-3">
                <label for="name" class="form-label">Nom du centre <span class="text-danger">*</span></label>
                <input type="text" name="name" id="name" 
                       class="form-control @error('name') is-invalid @enderror" 
                       value="{{ old('name') }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Région -->
            <div class="mb-3">
                <label for="region" class="form-label">Région <span class="text-danger">*</span></label>
                <select name="region" id="region" 
                        class="form-select @error('region') is-invalid @enderror form-control" required>
                    <option value="">-- Sélectionnez une région --</option>
                    @foreach(['Dakar','Diourbel','Fatick','Kaffrine','Kaolack','Kédougou','Kolda','Louga','Matam','Saint-Louis','Sédhiou','Tambacounda','Thiès','Ziguinchor'] as $region)
                        <option value="{{ $region }}" {{ old('region') == $region ? 'selected' : '' }}>
                            {{ $region }}
                        </option>
                    @endforeach
                </select>
                @error('region')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label for="contact_email" class="form-label">Email de contact</label>
                <input type="email" name="contact_email" id="contact_email"
                       class="form-control @error('contact_email') is-invalid @enderror"
                       value="{{ old('contact_email') }}">
                @error('contact_email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Téléphone -->
            <div class="mb-3">
                <label for="contact_phone" class="form-label">Téléphone</label>
                <input type="number" name="contact_phone" id="contact_phone"
                       class="form-control @error('contact_phone') is-invalid @enderror"
                       value="{{ old('contact_phone') }}">
                @error('contact_phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Boutons -->
            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('admin.centres.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times me-1"></i> Annuler
                </a>
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-check me-1"></i> Créer le centre
                </button>
            </div>
        </form>
    </div>
</div>
@stop
