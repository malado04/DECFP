@extends('adminlte::page')

@section('title', 'Éditer une compétence')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
@stop

@section('content_header')
<div class="card-left-warning card-header bg-light">
    <h3 class="m-0 text-warning">
        <i class="fas fa-edit me-2"></i> Éditer compétence
        <a href="{{ route('admin.competencies.index') }}" class="btn btn-outline-danger float-end">
            <i class="fas fa-arrow-left me-1"></i> Retour
        </a>
    </h3>
</div>
@stop

@section('content')
<div class="card card-left-warning shadow border-start border-warning border-4">
    <div class="card-body">
        <form action="{{ route('admin.competencies.update', $competency) }}" method="POST">
            @csrf
            @method('PUT')
        <div class="row">
            <div class="col-md-6">
                
            <div class="mb-3">
                <label class="form-label">Examen <span class="text-danger">*</span></label>
                <select name="exam_id" class="form-select form-control" required>
                    @foreach(\App\Models\Exam::all() as $exam)
                        <option value="{{ $exam->id }}" {{ old('exam_id', $competency->exam_id) == $exam->id ? 'selected' : '' }}>
                            {{ $exam->title }}
                        </option>
                    @endforeach
                </select>
                @error('exam_id') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Coefficient</label>
                <input type="number" name="coefficient" class="form-control" step="1" value="{{ old('coefficient', $competency->coefficient ?? 1) }}">
                @error('coefficient') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Groupe</label>
                <input type="text" name="group" class="form-control" value="{{ old('group', $competency->group) }}">
                @error('group') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Ordre</label>
                <input type="number" name="order" class="form-control" step="1" value="{{ old('order', $competency->order ?? 1) }}">
                @error('order') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                <label class="form-label">Titre <span class="text-danger">*</span></label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $competency->title) }}" required>
                @error('title') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description', $competency->description) }}</textarea>
                @error('description') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Score maximum <span class="text-danger">*</span></label>
                <input type="number" name="max_score" class="form-control" step="0.01" value="{{ old('max_score', $competency->max_score) }}" required>
                @error('max_score') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>
            </div>
        </div>

            <!-- <div class="mb-3">
                <label class="form-label">Code</label>
                <input type="text" name="code" class="form-control" value="{{ old('code', $competency->code) }}">
                @error('code') <span class="text-danger small">{{ $message }}</span> @enderror
            </div> -->

            

            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('admin.competencies.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Retour
                </a>
                <button type="submit" class="btn btn-warning">
                    <i class="fas fa-save me-1"></i> Mettre à jour
                </button>
            </div>
        </form>
    </div>
</div>
@stop
