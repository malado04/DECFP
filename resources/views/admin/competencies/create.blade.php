@extends('adminlte::page')

@section('title', 'Créer une compétence')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
@stop

@section('content_header')
<div class="card-left-success card-header bg-light">
    <h3 class="m-0 text-success">
        <i class="fas fa-plus-circle me-2"></i> Nouvelle compétence
        <a href="{{ route('admin.competencies.index') }}" class="btn btn-outline-danger float-end">
            <i class="fas fa-arrow-left me-1"></i> Retour
        </a>
    </h3>
</div>
@stop

@section('content')
<div class="card card-left-success shadow border-start border-success border-4">
    <div class="card-body">
        <form action="{{ route('admin.competencies.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    
            <div class="mb-3">
                <label class="form-label">Examen <span class="text-danger">*</span></label>
                <select name="exam_id" class="form-select form-control" required>
                    <option value="">-- Sélectionner un examen --</option>
                    @foreach(exams as $exam)
                        <option value="{{ $exam->id }}" {{ old('exam_id') == $exam->id ? 'selected' : '' }}>
                            {{ $exam->title }}
                        </option>
                    @endforeach
                </select>
                @error('exam_id') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Coefficient</label>
                <input type="number" name="coefficient" class="form-control" step="1" value="{{ old('coefficient', 1) }}">
                @error('coefficient') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Groupe <span class="text-danger">*</span></label>
                <select name="group_id" class="form-select" required>
                    <option value="">-- Sélectionner un groupe --</option>

                    @foreach(groups as $group)
                        <option value="{{ $group->id }}">
                            {{ $group->name }}
                        </option>
                    @endforeach
                </select>

                @error('group_id') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>


            <div class="mb-3">
                <label class="form-label">Ordre</label>
                <input type="number" name="order" class="form-control" step="1" value="{{ old('order', 1) }}">
                @error('order') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>

                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                <label class="form-label">Titre <span class="text-danger">*</span></label>
                <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                @error('title') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                @error('description') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Score maximum <span class="text-danger">*</span></label>
                <input type="number" name="max_score" class="form-control" step="0.01" value="0" required>
                @error('max_score') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Compétence de :</label>
                <select class="form-control" name="tour">
                    <option value="1">Premier tour</option>
                    <option value="2">Second tour</option>
                </select>
                @error('code') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>
            

            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('admin.competencies.index') }}" class="btn btn-secondary">
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
