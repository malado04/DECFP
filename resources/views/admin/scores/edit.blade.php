@extends('adminlte::page')

@section('title', 'Éditer le score')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
@stop
@section('content_header')
<div class="card-left-success card-header bg-light">
    <h3 class="m-0 text-success">
        <i class="fas fa-pen me-2"></i> Éditer le score
        <a href="{{ route('admin.exam_sessions.show', $score->session->id) }}" class="btn btn-outline-secondary float-end">
            <i class="fas fa-arrow-left me-1"></i> Retour à la session
        </a>
    </h3>
</div>
@stop

@section('content')
<div class="card card-left-success shadow border-start border-success border-4">
    <div class="card-body bg-light">

        <h4 class="mb-4">
            <strong>Candidat :</strong> {{ $score->candidate->full_name }}<br>
            <strong>Compétence :</strong> {{ $score->competency->title }}<br>
            <strong>Session :</strong> {{ $score->session->name }}
        </h4>

        <form action="{{ route('admin.scores.update', $score) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row g-3">

                {{-- Score --}}
                <div class="col-md-4">
                    <label for="score">Score</label>
                    <input type="number" step="0.01" min="0" max="20" name="score" id="score" class="form-control"
                           value="{{ old('score', $score->score) }}" required>
                </div>

                {{-- Status --}}
                <div class="col-md-4">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control">
                        <option value="present" {{ $score->status == 'present' ? 'selected' : '' }}>Présent</option>
                        <option value="absent" {{ $score->status == 'absent' ? 'selected' : '' }}>Absent</option>
                        <option value="ajourne" {{ $score->status == 'ajourne' ? 'selected' : '' }}>Ajourné</option>
                    </select>
                </div>

                {{-- Validation par jury --}}
                <div class="col-md-4">
                    <label>Validation</label>
                    @if($score->validated_at)
                        <div class="alert alert-success mt-2">
                            Validé par {{ $score->validatedBy->name ?? 'N/A' }}<br>
                            Le {{ $score->validated_at->format('d/m/Y H:i') }}
                        </div>
                    @else
                        <button type="submit" name="validate" value="1" class="btn btn-success mt-4">
                            Valider ce score
                        </button>
                    @endif
                </div>

            </div>

            <hr>

            <button type="submit" class="btn btn-primary">
                Enregistrer les modifications
            </button>

        </form>
    </div>
</div>
@stop

@section('js')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Ici tu peux ajouter le JS pour modification rapide via AJAX si besoin
});
</script>
@stop
