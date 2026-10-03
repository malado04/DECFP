@extends('adminlte::page')

@section('title', 'Éditer un centre')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
@stop

@section('content_header')
<div class="card-left-warning card-header bg-light">
    <h3 class="m-0 text-warning">
        <i class="fas fa-school me-2"></i> Éditer le centre
        <a href="{{ route('admin.centres.index') }}" class="btn btn-secondary float-end">
            <i class="fas fa-arrow-left me-1"></i> Retour
        </a>
    </h3>
</div>
@stop

@section('content')
<div class="card card-left-warning shadow border-start border-warning border-4">
    <div class="card-body bg-light">
        <form action="{{ route('admin.centres.update', $centre) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="code" class="form-label">Code</label>
                    <input type="text" name="code" id="code" class="form-control" value="{{ old('code', $centre->code) }}" required>
                </div>
                <div class="col-md-6">
                    <label for="name" class="form-label">Nom du centre</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $centre->name) }}" required>
                </div>
            </div>

            <div class="row g-3 mt-2">
                <div class="col-md-6">
                    <label for="region" class="form-label">Région</label>
                <select name="region" id="region" 
                        class="form-select form-control @error('region') is-invalid @enderror" required>
                    <option value="">-- Sélectionnez une région --</option>
                    @foreach(['Dakar','Diourbel','Fatick','Kaffrine','Kaolack','Kédougou','Kolda','Louga','Matam','Saint-Louis','Sédhiou','Tambacounda','Thiès','Ziguinchor'] as $region)
                        <option value="{{ $region }}" {{ old('region', $centre->region) == $region ? 'selected' : '' }}>
                            {{ $region }}
                        </option>
                    @endforeach
                </select>
                </div>
                <div class="col-md-6">
                    <label for="contact_email" class="form-label">Email</label>
                    <input type="email" name="contact_email" id="contact_email" class="form-control" value="{{ old('contact_email', $centre->contact_email) }}">
                </div>
            </div>

            <div class="row g-3 mt-2">
                <div class="col-md-6">
                    <label for="contact_phone" class="form-label">Téléphone</label>
                    <input type="text" name="contact_phone" id="contact_phone" class="form-control" value="{{ old('contact_phone', $centre->contact_phone) }}">
                </div>
            </div>

            <div class="mt-4 text-end">
                <button type="submit" class="btn btn-warning">
                    <i class="fas fa-save me-1"></i> Mettre à jour
                </button>
            </div>
        </form>
    </div>
</div>
@stop
