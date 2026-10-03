@extends('adminlte::page')

@section('title', 'Procès-Verbal Global')

@section('content_header')
<h1 class="text-primary fw-bold">PROCÈS VERBAL – {{ $exam->title }}</h1>
@stop

@section('content')


{{-- ============================================================
       ENTÊTE OFFICIEL DE LA RÉPUBLIQUE DU SÉNÉGAL
============================================================== --}}
<div class="text-center mb-4">

    <img src="{{ asset('images/senegal_logo.png') }}" alt="Armoiries Sénégal" width="90" class="mb-2">

    <h4 class="fw-bold text-uppercase">République du Sénégal</h4>
    <h6 class="text-uppercase">Un Peuple – Un But – Une Foi</h6>

    <hr class="w-25 mx-auto">

    <h5 class="fw-bold text-uppercase mt-3">
        Ministère de l’Emploi, de la Formation Professionnelle et Technique
    </h5>

    <h5 class="fw-bold text-uppercase">
        Direction des Examens et Concours
    </h5>

    <h4 class="fw-bold mt-4">
        PROCÈS-VERBAL – {{ $exam->title }} – Session {{ date('Y') }}
    </h4>

    <h5 class="fw-bold mt-3">
        CENTRE : {{ strtoupper($centre->name) }}
    </h5>

</div>





{{-- ============================================================
       TABLEAU OFFICIEL : NE < / COEFF (1er & 2e TOUR)
============================================================== --}}
<table class="pv-table mb-4">

    <tr class="pv-header-1">
        <td colspan="{{ $firstTourCompetencies->count() + 1 }}">EPREUVE DU 1er TOUR</td>
        <td colspan="{{ $secondTourCompetencies->count() + 1 }}">EPREUVE DU 2ème TOUR</td>
    </tr>

    {{-- LIGNE NE < --}}
    <tr>
        <td class="pv-lightblue">NE &lt;</td>

        @foreach($firstTourCompetencies as $c)
            <td>{{ $c->max_score ?? '' }}</td>
        @endforeach

        <td class="pv-yellow">TOTAL</td>

        @foreach($secondTourCompetencies as $c)
            <td>{{ $c->max_score ?? '' }}</td>
        @endforeach

        <td class="pv-yellow">TOTAL</td>
    </tr>

    {{-- LIGNE COEFF --}}
    <tr>
        <td class="pv-lightblue">COEFF</td>

        @foreach($firstTourCompetencies as $c)
            <td>{{ $coeffs->firstWhere('competency_id', $c->id)->weight ?? '' }}</td>
        @endforeach

        <td class="pv-yellow fw-bold">
            {{ $coeffs->whereIn('competency_id',$firstTourCompetencies->pluck('id'))->sum('weight') }}
        </td>

        @foreach($secondTourCompetencies as $c)
            <td>{{ $coeffs->firstWhere('competency_id', $c->id)->weight ?? '' }}</td>
        @endforeach

        <td class="pv-yellow fw-bold">
            {{ $coeffs->whereIn('competency_id',$secondTourCompetencies->pluck('id'))->sum('weight') }}
        </td>
    </tr>

</table>



{{-- ============================================================
       GRAND TABLEAU DES NOTES — PV COMPLET
============================================================== --}}
<table class="pv-table">

    <tr class="pv-header-2">
        <th>N° Anonymat</th>
        <th>Nom & Prénom</th>

        @foreach($firstTourCompetencies as $comp)
            <th>{{ $comp->title }}</th>
        @endforeach

        <th>Total 1er Tour</th>

        @foreach($secondTourCompetencies as $comp)
            <th>{{ $comp->title }}</th>
        @endforeach

        <th>Total 2e Tour</th>
        <th>Moyenne</th>
        <th>Décision</th>
        <th>Mention</th>
    </tr>

    @foreach($students as $i => $s)
        <tr>
            <td>{{ $s->anonymat_number }}</td>
            <td>{{ $s->full_name }}</td>

            {{-- 1er TOUR --}}
            @php $total1 = 0; @endphp

            @foreach($firstTourCompetencies as $c)
                @php
                    $note = $scores[$s->id][$c->id] ?? 'A';
                    $coef = $coeffs->firstWhere('competency_id',$c->id)->weight ?? 1;
                    if($note !== 'A') $total1 += $note * $coef;
                @endphp
                <td>{{ $note }}</td>
            @endforeach

            <td class="pv-yellow">{{ number_format($total1,2) }}</td>

            {{-- 2e TOUR --}}
            @php $total2 = 0; @endphp

            @foreach($secondTourCompetencies as $c)
                @php
                    $note2 = $scores[$s->id][$c->id] ?? 'A';
                    $coef2 = $coeffs->firstWhere('competency_id',$c->id)->weight ?? 1;
                    if($note2 !== 'A') $total2 += $note2 * $coef2;
                @endphp
                <td>{{ $note2 }}</td>
            @endforeach

            <td class="pv-yellow">{{ number_format($total2,2) }}</td>

            {{-- MOYENNE --}}
            @php
                $moy = ($total1 + $total2) / $coeffs->sum('weight');
            @endphp

            <td class="pv-green">{{ number_format($moy, 2) }}</td>

            {{-- DECISION --}}
            <td>
                @if($moy >= 10) ADMIS
                @elseif($moy >= 8) REPÊCHAGE
                @else AJOURNÉ @endif
            </td>

            {{-- MENTION --}}
            <td>
                @if($moy >= 16) Très Bien
                @elseif($moy >= 14) Bien
                @elseif($moy >= 12) Assez Bien
                @elseif($moy >= 10) Passable
                @else — @endif
            </td>
        </tr>
    @endforeach

</table>


{{-- ==================== STYLES TABLE PV ==================== --}}
<style>
    .pv-table {
        border-collapse: collapse;
        width: 100%;
        font-size: 11px;
        text-align: center;
    }

    .pv-table th, .pv-table td {
        border: 1px solid black;
        padding: 3px;
    }

    .pv-header-1 {
        background: #e6f4ff;
        font-weight: bold;
    }

    .pv-header-2 {
        background: #f2f2f2;
        font-weight: bold;
    }

    .pv-lightblue {
        background: #c7eef9;
    }

    .pv-yellow {
        background: #fff7b0;
        font-weight: bold;
    }

    .pv-green {
        background: #d7ffd7;
        font-weight: bold;
    }
</style>

@endsection
