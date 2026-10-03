<table class="table table-bordered">
    <thead class="bg-success text-white text-center">
        <tr>
            <th rowspan="2">Candidat</th>
            <th colspan="7">1er Tour</th>
            <th colspan="7">2e Tour</th>
            <th rowspan="2">Total Général</th>
            <th rowspan="2">Mention</th>
            <th rowspan="2">Décision</th>
        </tr>
        <tr>
            <th>Techni Expression</th>
            <th>OTGMM</th>
            <th>Procédure</th>
            <th>Norm-Qualit</th>
            <th>Droit Transport</th>
            <th>Total</th>
            <th>Moyenne</th>

            <th>GEJ</th>
            <th>Informatique</th>
            <th>Stage</th>
            <th>Total</th>
            <th>Moyenne</th>
            <th>Autres</th>
            <th>...</th>
        </tr>
    </thead>
    <tbody class="text-center">
        @foreach($pvData as $res)
            <tr>
                <td>{{ $res['candidate']->full_name }}</td>

                {{-- 1er tour --}}
                @foreach($res['session1'] as $val)
                    <td>{{ is_array($val) ? implode(', ', $val) : $val }}</td>
                @endforeach

                {{-- 2e tour --}}
                @foreach($res['session2'] as $val)
                    <td>{{ is_array($val) ? implode(', ', $val) : $val }}</td>
                @endforeach

                <td>{{ $res['total_general'] }}</td>
                <td>{{ $res['mention'] }}</td>
                <td>{{ $res['decision'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
<div class="row mt-5">
    <div class="col text-center">
        Le Secrétaire<br><br><br>
        {{ $secretaire->name ?? '---' }}
    </div>
    <div class="col text-center">
        Le Président du jury<br><br><br>
        {{ $president->name ?? '---' }}
    </div>
</div>
