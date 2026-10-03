@extends('adminlte::page')

@section('title', 'Saisie des scores')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
@stop

@section('content_header')
<div class="card-header card-left-success bg-light border-start border-4 border-success">
    <h1 class="m-0">
        <i class="fas fa-pen me-2 text-success"></i>
        Saisie des scores – {{ $exam_session->exam->title }} ({{ $exam_session->name }})
        <a href="{{ route('admin.exam_sessions.showM', $exam_session->id) }}"
           class="btn btn-outline-danger float-end">
            <i class="fas fa-arrow-left me-1"></i> Retour
        </a>
    </h1>
</div>
@stop


@section('content')

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('warning'))
<div class="alert alert-warning">{{ session('warning') }}</div>
@endif

@if($candidates->isEmpty() || $competencies->isEmpty())
<div class="alert alert-info">
    ⚠️ Impossible de saisir les scores : aucun candidat ou compétence n'est défini.
</div>
@else

<form action="{{ route('admin.scores.store') }}" method="POST">
    @csrf
    <input type="hidden" name="exam_session_id" value="{{ $exam_session->id }}">

    <div class="card shadow  card-left-success bg-light border-start border-4 border-success">
        <div class="card-body table-responsive">

            <table class="table table-bordered table-striped table-sm text-center align-middle">
                <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Candidat</th>

                    @foreach($competencies as $competency)
                        <th>
                            {{ $competency->code }}<br>
                            <small class="text-muted"><b><u>Titre</u></b> : {{ $competency->title }}</small><br>
                            <small class="text-muted"><b><u>Coef</u></b> : {{ $competency->coefficient }}</small>
                        </th>
                    @endforeach

                    <th>Moyenne</th>
                    <th>Statut</th>
                </tr>
                </thead>

                <tbody>

                @foreach($candidates as $index => $candidate)
                    <tr>
                        <td>{{ $index + 1 }}</td>

                        <td class="text-start">
                            <strong>{{ $candidate->full_name }}</strong><br>
                            <small>{{ $candidate->centre->name }}</small>
                        </td>

                        {{-- --- COMPÉTENCES --- --}}
                        @foreach($competencies as $competency)

                            @php
                                $key = $candidate->id.'-'.$competency->id;
                                $score = $scores[$key][0] ?? null;
                            @endphp

                            <td class="@if($score && $score->validated_at) bg-success bg-opacity-10 @endif">

                                {{-- Score brut --}}
                                <input type="number"
                                       class="form-control form-control-sm score-input"
                                       name="scores[{{ $candidate->id }}][{{ $competency->id }}][score]"
                                       value="{{ $score->score ?? '' }}"
                                       placeholder="0-20"
                                       min="0" max="20" step="0.01"
                                       data-candidate="{{ $candidate->id }}"
                                       data-competency="{{ $competency->id }}"
                                       data-session="{{ $exam_session->id }}"
                                        @if($score && $score->validated_at) readonly @else required @endif>
                                {{-- Statut */}
                                <select class="form-select form-select-sm mt-1 status-input"
                                        name="scores[{{ $candidate->id }}][{{ $competency->id }}][status]"
                                        data-candidate="{{ $candidate->id }}"
                                        data-competency="{{ $competency->id }}"
                                        data-session="{{ $exam_session->id }}"
                                        @if($score && $score->validated_at) disabled @endif >
                                    <option value="present"  @selected(optional($score)->status == 'present')>Présent</option>
                                    <option value="absent"   @selected(optional($score)->status == 'absent')>Absent</option>
                                    <option value="ajourne"  @selected(optional($score)->status == 'ajourne')>Ajourné</option>
                                </select>

                                {{-- Score pondéré --}}
                                @if($score && $score->weighted_score)
                                    <small class="text-primary">Pondéré : <strong>{{ $score->weighted_score }}</strong></small>
                                @endif

                                {{-- Bouton Valider --}}
                                @if(!$score || !$score->validated_at)
                                    <button type="button"
                                            class="btn btn-outline-success btn-sm mt-1 validate-score-btn"
                                            data-score="{{ $score->id ?? 0 }}"
                                            data-candidate="{{ $candidate->id }}"
                                            data-competency="{{ $competency->id }}"
                                            data-session="{{ $exam_session->id }}">
                                        Valider
                                    </button>
                                @else
                                    <small class="text-success d-block mt-1">
                                        ✔ Validé<br>
                                        <small>{{ $score->validated_at->format('d/m H:i') }}</small>
                                    </small>
                                @endif

                            </td>
                        @endforeach

                        {{-- MOYENNE --}}
                        @php
                            $avg = $candidate->calculateFinalAverage($exam_session->id);
                            $status = $candidate->getStatusForSession($exam_session->id);
                        @endphp

                        <td class="fw-bold">{{ $avg }}</td>

                        <td class="fw-bold
                            {{ $status == 'ADMIS' ? 'text-success' : 'text-danger' }}">
                            {{ $status }}
                        </td>

                    </tr>
                @endforeach

                </tbody>

            </table>

        </div>

        <div class="card-footer text-end">
            <button class="btn btn-success">
                <i class="fas fa-save me-1"></i> Enregistrer tous les scores
            </button>
        </div>
    </div>

</form>

@endif
@stop



@section('js')
<script>
$(function() {

    $('.validate-score-btn').on('click', function() {
        let btn = $(this);
        let sessionId = btn.data('session');
        let candidateId = btn.data('candidate');
        let competencyId = btn.data('competency');
        let scoreId = btn.data('score');

        let td = btn.closest('td');
        let score = td.find('.score-input').val();
        let status = td.find('.status-input').val();

        $.post("{{ url('admin/scores/validate') }}", {
            _token: "{{ csrf_token() }}",
            exam_session_id: sessionId,
            candidate_id: candidateId,
            competency_id: competencyId,
            score: score,
            status: status
        })
        .done(function(res) {

            td.addClass('bg-success bg-opacity-10');
            td.find('.score-input').prop('readonly', true);
            td.find('.status-input').prop('disabled', true);
            btn.remove();

            td.append(`
                <small class="text-success d-block mt-1">
                    ✔ Validé (${res.validatedBy})
                </small>
            `);
        })
        .fail(function(xhr) {
            alert("Erreur : impossible de valider le score");
            console.error(xhr.responseText);
        });
    });

});
</script>
@stop
