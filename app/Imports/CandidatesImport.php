<?php

namespace App\Imports;

use App\Models\Candidate;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CandidatesImport implements ToModel, WithHeadingRow
{
    protected $centreId;

    public function __construct($centreId)
    {
        $this->centreId = $centreId;
    }

    public function model(array $row)
    {
        return new Candidate([
            'registration_number' => $row['registration_number'] ?? null,
            'first_name'          => $row['first_name'],
            'last_name'           => $row['last_name'],
            'sex'                 => $row['sex'] ?? null,
            'birthdate'           => isset($row['birthdate']) ? date('Y-m-d', strtotime($row['birthdate'])) : null,
            'national_id'         => $row['national_id'] ?? null,
            'status'              => $row['status'] ?? 'inscrit',
            'centre_id'           => $this->centreId,
        ]);
    }
}
