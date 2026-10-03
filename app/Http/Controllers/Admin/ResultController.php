<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExamSession;
use App\Models\Exam;
use App\Models\User;
use App\Models\CcpWeight;
use App\Services\ResultService;

class ResultController extends Controller
{
    /**
     * Page PV (tableau type Excel)
     */
 public function index(ResultService $resultService, $session1Id, $session2Id = null)
{
    /**
     * ===============================
     * 1️⃣ Sessions + Exam + Centre
     * ===============================
     */
    $session1 = ExamSession::findOrFail($session1Id);
    $session2 = $session2Id ? ExamSession::find($session2Id) : null;

    $exam   = $session1->exam;
    $centre = $exam->centre;

    /**
     * ===============================
     * 2️⃣ Construction PV complet
     * ===============================
     */
    $pvData = $resultService->buildPvData($session1, $session2);

    /**
     * ===============================
     * 3️⃣ Liste candidats
     * ===============================
     */
    $students   = collect($pvData)->pluck('candidate');
    $candidates = $students; // alias

    /**
     * ===============================
     * 4️⃣ Scores + décision par candidat
     * ===============================
     */
    $scores    = collect();
    $decisions = collect();

    foreach ($pvData as $row) {
        $candidateId = $row['candidate']->id;

        // Scores par compétence
        $scores[$candidateId] = $row['scores'] ?? [];

        // Décision finale (vient de `decision`, pas finalDecision)
        $decisions[$candidateId] = $row['decision'] ?? 'AJOURNÉ';
    }

    /**
     * ===============================
     * 5️⃣ Colonnes dynamiques (2ᵉ tour)
     * ===============================
     */
    $dynamicCols = $resultService->buildDynamicColumns($exam, $session2);

    /**
     * ===============================
     * 6️⃣ Jury
     * ===============================
     */
    $secretaire = User::where('role', 'secretaire')->first();
    $president  = User::where('role', 'président')->first();

    /**
     * ===============================
     * 7️⃣ Statistiques PV (version fusionnée)
     * ===============================
     */

    $garcons = $candidates->where('gender', 'M');
    $filles  = $candidates->where('gender', 'F');

    // Fonction %
    $percent = function ($value, $total) {
        return $total > 0 ? round(($value / $total) * 100, 2) : 0;
    };

    // Stats garçons
    $stats = [
        'garcons' => [
            'presents'     => $garcons->count(),
            'admissibles'  => $garcons->where('is_admissible', 1)->count(),
            'admis'        => $garcons->where('is_admis', 1)->count(),
        ],
        'filles' => [
            'presents'     => $filles->count(),
            'admissibles'  => $filles->where('is_admissible', 1)->count(),
            'admis'        => $filles->where('is_admis', 1)->count(),
        ],
    ];

    // Pourcentage par sexe
    $stats['garcons']['percent'] = $percent(
        $stats['garcons']['admis'],
        $stats['garcons']['presents']
    );

    $stats['filles']['percent'] = $percent(
        $stats['filles']['admis'],
        $stats['filles']['presents']
    );

    // Stats globales
    $totalPresents = $stats['garcons']['presents'] + $stats['filles']['presents'];
    $totalAdmis    = $stats['garcons']['admis'] + $stats['filles']['admis'];

    $stats['global'] = [
        'presents' => $totalPresents,
        'admis'    => $totalAdmis,
        'percent'  => $percent($totalAdmis, $totalPresents),
    ];
$stats = [
    'garcons' => [
        'presents'    => $garcons->count(),
        'admissibles' => $garcons->where('is_admissible', 1)->count(),
        'admis'       => $garcons->where('is_admis', 1)->count(),
        'percent'     => percent($stats['garcons']['admis'], $stats['garcons']['presents'])
    ],

    'filles' => [
        'presents'    => $filles->count(),
        'admissibles' => $filles->where('is_admissible', 1)->count(),
        'admis'       => $filles->where('is_admis', 1)->count(),
        'percent'     => percent($stats['filles']['admis'], $stats['filles']['presents'])
    ],

    'global' => [
        'presents' => $totalPresents,
        'admis'    => $totalAdmis,
        'percent'  => percent($totalAdmis, $totalPresents)
    ]
];

    /**
     * ===============================
     * 8️⃣ Coefficients (1er + 2e tour)
     * ===============================
     */
    $coeffs = CcpWeight::with('competency')
        ->where('exam_id', $exam->id)
        ->get();

    /**
     * ===============================
     * 9️⃣ Compétences par tour
     * ===============================
     */
    $firstTourCompetencies = $exam->competencies()
        ->where('round', 1)
        ->orderBy('order')
        ->get();

    $secondTourCompetencies = $exam->competencies()
        ->where('round', 2)
        ->orderBy('order')
        ->get();

    /**
     * ===============================
     * 🔟 Rendu vue
     * ===============================
     */
    return view('admin.results.index', compact(
        'pvData',
        'session1',
        'session2',
        'dynamicCols',
        'secretaire',
        'president',
        'stats',
        'exam',
        'centre',
        'coeffs',
        'students',
        'scores',
        'firstTourCompetencies',
        'secondTourCompetencies',
        'decisions'
    ));
}


    /**
     * PV imprimable (PDF / écran)
     */
    public function pv(ResultService $resultService, $session1Id, $session2Id = null)
    {
        $session1 = ExamSession::findOrFail($session1Id);
        $session2 = $session2Id ? ExamSession::find($session2Id) : null;

        $pvData = $resultService->buildPvData($session1, $session2);

        return view('admin.results.pv', compact('session1', 'session2', 'pvData'));
    }


    /**
     * Recalcul complet des résultats + enregistrement dans DB
     */
    public function recalculate(ResultService $resultService, ExamSession $session1, ExamSession $session2 = null)
    {
        $resultService->recalculateAndSave($session1, $session2);

        return back()->with('success', 'Résultats recalculés avec succès.');
    }
}
