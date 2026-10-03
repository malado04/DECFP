    @yield('layouts.app')

    @yield('content')

<div class="container mx-auto py-8">
    <h1 class="text-3xl font-bold mb-6">Tableau de bord</h1>

    @php
        $user = auth()->user();
    @endphp

    {{-- Super Admin --}}
    @if($user->hasRole('super-admin'))
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-blue-500 text-white p-6 rounded shadow">
            <h2 class="text-lg font-bold">Utilisateurs</h2>
            <p class="text-2xl mt-2">{{ $stats['total_users'] }}</p>
        </div>
        <div class="bg-green-500 text-white p-6 rounded shadow">
            <h2 class="text-lg font-bold">Centres</h2>
            <p class="text-2xl mt-2">{{ $stats['total_centres'] }}</p>
        </div>
        <div class="bg-yellow-500 text-white p-6 rounded shadow">
            <h2 class="text-lg font-bold">Examens</h2>
            <p class="text-2xl mt-2">{{ $stats['total_exams'] }}</p>
        </div>
        <div class="bg-red-500 text-white p-6 rounded shadow">
            <h2 class="text-lg font-bold">Candidats</h2>
            <p class="text-2xl mt-2">{{ $stats['total_candidates'] }}</p>
        </div>
    </div>
    @endif

    {{-- Ministère --}}
    @if($user->hasRole('ministere'))
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-green-500 text-white p-6 rounded shadow">
            <h2 class="text-lg font-bold">Centres</h2>
            <p class="text-2xl mt-2">{{ $stats['total_centres'] }}</p>
        </div>
        <div class="bg-yellow-500 text-white p-6 rounded shadow">
            <h2 class="text-lg font-bold">Examens</h2>
            <p class="text-2xl mt-2">{{ $stats['total_exams'] }}</p>
        </div>
        <div class="bg-red-500 text-white p-6 rounded shadow">
            <h2 class="text-lg font-bold">Candidats</h2>
            <p class="text-2xl mt-2">{{ $stats['total_candidates'] }}</p>
        </div>
    </div>
    @endif

    {{-- Regional / Centre Admin --}}
    @if($user->hasRole('regional-admin') || $user->hasRole('centre-admin'))
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-red-500 text-white p-6 rounded shadow">
            <h2 class="text-lg font-bold">Candidats</h2>
            <p class="text-2xl mt-2">{{ $stats['total_candidates'] }}</p>
        </div>
        <div class="bg-yellow-500 text-white p-6 rounded shadow">
            <h2 class="text-lg font-bold">Examens</h2>
            <p class="text-2xl mt-2">{{ $stats['total_exams'] }}</p>
        </div>
    </div>
    @endif

    {{-- Jury / Secrétaire / Lecteur --}}
    @if($user->hasRole('jury') || $user->hasRole('secretaire') || $user->hasRole('lecteur'))
    <div class="grid grid-cols-1 gap-6">
        <div class="bg-blue-500 text-white p-6 rounded shadow">
            <h2 class="text-lg font-bold">Examens disponibles</h2>
            <ul class="mt-2 list-disc list-inside">
                @foreach($exams as $exam)
                    <li>{{ $exam->title }} ({{ $exam->code }})</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

</div>
@endsection
