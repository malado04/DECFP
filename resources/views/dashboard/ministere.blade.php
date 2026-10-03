@extends('adminlte::page')

@section('title', 'Tableau de bord - Admin')

@section('content_header')
<h4 class="m-0 text-dark"><b>Tableau de bord Ministère</b></h4>
@stop

@section('content')

{{-- Filtres --}}
<div class="card mb-4">
    <div class="card-body">

    </div>
</div>

@stop

@push('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush
