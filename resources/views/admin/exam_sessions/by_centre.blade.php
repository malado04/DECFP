@extends('adminlte::page')

@section('title', 'Sessions - ' . $centre->name)

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
@stop

@section('content_header')
<div class="card-left-success card-header bg-light">
    <h3 class="m-0 text-success">
                <i class="fas fa-school"></i>
       Sessions du centre : {{ $centre->name }}
    </h3>
</div>
@stop

@section('content')

@forelse($sessions as $examTitle => $examSessions)

    <div class="card card-left-success mb-4">
        <div class="card-header bg-light">
            <h5 class="mb-0">
                <i class="fas fa-book text-info"></i>
                {{ $examTitle }}
            </h5>
        </div>

        <div class="card-body p-0">
            <table class="table table-striped table-hover mb-0">
                <thead class="table-secondary">
                    <tr>
                        <th>Session</th>
                        <th>Année</th>
                        <th>Début</th>
                        <th>Fin</th>
                        <th>Type</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($examSessions as $session)
                        <tr>
                            <td>
                                <span class="badge bg-primary">
                                    {{ $session->name }}
                                </span>
                            </td>
                            <td>{{ $session->academic_year }}</td>
                            <td>{{ $session->start_date->format('d/m/Y') }}</td>
                            <td>{{ $session->end_date->format('d/m/Y') }}</td>
                            <td>
                                <span class="badge bg-info">
                                    {{ ucfirst($session->type) }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@empty
    <div class="alert alert-warning">
        <i class="fas fa-exclamation-circle"></i>
        Aucune session pour ce centre.
    </div>
@endforelse

@stop
