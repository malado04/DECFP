@extends('adminlte::page')

@section('title', 'Pondérations CCP')

@section('content_header')
    <h1>Pondérations — {{ $exam->title }}</h1>
@stop

@section('content')

{{-- Notifications Toastr --}}
@if(session('success'))
    <script>
        toastr.success("{{ session('success') }}");
    </script>
@endif
@if(session('error'))
    <script>
        toastr.error("{{ session('error') }}");
    </script>
@endif

<div class="card">
    <div class="card-header bg-primary">
        <h3 class="card-title">Définir les pondérations des CCP</h3>
    </div>

    <div class="card-body">

        <form method="POST" action="{{ route('ccp.weights.update', $exam->id) }}">
            @csrf

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Compétence</th>
                        <th width="150">Pondération (%)</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($competencies as $comp)
                        <tr>
                            <td>{{ $comp->code }}</td>
                            <td>{{ $comp->title }}</td>
                            <td>
                                <input type="number"
                                    class="form-control w-75 weight-input"
                                    name="weights[{{ $comp->id }}]"
                                    value="{{ $weights[$comp->id] ?? 0 }}"
                                    step="0.01"
                                    min="0"
                                    max="100">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <hr>

            <h4>Total : <span id="totalWeight">0</span>%</h4>

            <button id="saveBtn" class="btn btn-success mt-3" disabled>
                <i class="fa fa-save"></i> Enregistrer
            </button>

        </form>

    </div>
</div>

@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
@stop

@section('js')
    <script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>

    <script>
        function updateTotal() {
            let total = 0;
            document.querySelectorAll('.weight-input').forEach(input => {
                total += parseFloat(input.value) || 0;
            });

            document.getElementById('totalWeight').innerText = total.toFixed(2);

            const saveBtn = document.getElementById('saveBtn');

            if (total === 100) {
                saveBtn.disabled = false;
                saveBtn.classList.remove('btn-danger');
                saveBtn.classList.add('btn-success');
            } else {
                saveBtn.disabled = true;
                saveBtn.classList.remove('btn-success');
                saveBtn.classList.add('btn-danger');
            }
        }

        document.querySelectorAll('.weight-input').forEach(input => {
            input.addEventListener('input', updateTotal);
        });

        // Initial
        updateTotal();
    </script>
@stop
