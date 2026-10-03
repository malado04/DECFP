<?php

namespace App\Exports;

use App\Models\Candidate;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CandidatesExport implements FromCollection, WithHeadings
{
    protected $centreId;

    public function __construct($centreId)
    {
        $this->centreId = $centreId;
    }

    public function collection()
    {
        return Candidate::where('centre_id', $this->centreId)
            ->select('registration_number', 'first_name', 'last_name', 'sex', 'birthdate', 'national_id', 'status')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Numéro d’inscription',
            'Prénom',
            'Nom',
            'Sexe',
            'Date de naissance',
            'ID National',
            'Statut',
        ];
    }
}
