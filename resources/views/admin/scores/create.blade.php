@extends('adminlte::page')

@section('title', 'Ajouter un score')

@section('content_header')
    <h1>Ajouter un score</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">

        <h4>
            Session : <strong>{{ $session->title }}</strong>
        </h4>

        <form action="{{ route('scores.store') }}" method="POST">
            @csrf

            <input type="hidden" name="exam_session_id" value="{{ $session->id }}">

            <div class="row">

                {{-- Choix du candidat --}}
                <div class="col-md-6 mb-3">
                    <label>Candidat</label>
                    <select name="candidate_id" class="form-control" required>
                        <option value="">-- Sélectionner --</option>
                        @foreach ($candidates as $cand)
                            <option value="{{ $cand->id }}">
                                {{ $cand->fullname }} ({{ $cand->matricule }})
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Choix de la compétence --}}
                <div class="col-md-6 mb-3">
                    <label>Compétence</label>
                    <select name="competency_id" class="form-control" required>
                        <option value="">-- Sélectionner --</option>
                        @foreach ($competencies as $comp)
                            <option value="{{ $comp->id }}">
                                {{ $comp->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Score --}}
                <div class="col-md-6 mb-3">
                    <label>Score</label>
                    <input type="number" step="0.01" min="0" max="20"
                           name="score" class="form-control"
                           value="{{ old('score') }}">
                </div>

                {{-- Statut --}}
                <div class="col-md-6 mb-3">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="present">Présent</option>
                        <option value="absent">Absent</option>
                        <option value="ajourne">Ajourné</option>
                    </select>
                </div>

            </div>

            <hr>

            <button type="submit" class="btn btn-primary">
                Enregistrer
            </button>

            <a href="{{ route('sessions.scores', $session->id) }}" class="btn btn-secondary">
                Retour
            </a>

        </form>

    </div>
</div>
@stop
