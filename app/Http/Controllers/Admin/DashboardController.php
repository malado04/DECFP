<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\Centre;
use App\Models\Exam;
use App\Models\ExamSession;
use App\Models\Candidate;

class DashboardController extends Controller
{
    /**
     * 📊 Dashboard SUPER ADMIN
     */
  public function admin(Request $request)
{
    $user = auth()->user();

    /** ---------------------------------------------------------
     *  🔎 1. Récupération session sélectionnée + liste sessions
     * --------------------------------------------------------*/
    $sessionId       = $request->input('session_id');
    $selectedSession = $sessionId ? ExamSession::find($sessionId) : null;

    $allSessions = ExamSession::orderByDesc('start_date')->get();

    /** ---------------------------------------------------------
     *  🧮 2. Construction de la query candidats (filtrée si besoin)
     * --------------------------------------------------------*/
    $candidatesQuery = Candidate::query();

    if ($selectedSession) {
        $candidatesQuery->where('exam_session_id', $selectedSession->id);
    }

    /** ---------------------------------------------------------
     *  📊 3. Statistiques globales
     * --------------------------------------------------------*/
    $totalCandidates = $candidatesQuery->count();
    $totalSessions   = ExamSession::count();
    $totalCentres    = Centre::count();
    $totalJurys      = User::where('role', 'jury')->count();

    /** ---------------------------------------------------------
     *  🏆 4. Top 5 centres (en fonction de la session filtrée)
     * --------------------------------------------------------*/
    $topCentres = Centre::withCount([
            'candidates' => function ($q) use ($selectedSession) {
                if ($selectedSession) {
                    $q->where('exam_session_id', $selectedSession->id);
                }
            }
        ])
        ->orderByDesc('candidates_count')
        ->take(5)
        ->get();

    /** ---------------------------------------------------------
     *  👥 5. 10 derniers candidats inscrits
     * --------------------------------------------------------*/
    $recentCandidates = $candidatesQuery
        ->with(['examSession', 'centre'])
        ->latest()
        ->take(10)
        ->get();

    /** ---------------------------------------------------------
     *  🧠 6. Analyse CCP (difficulté, moyenne, poids)
     * --------------------------------------------------------*/
    $ccpAnalysis = \App\Models\CcpWeight::with('competency')
        ->leftJoin('scores', 'scores.competency_id', '=', 'ccp_weights.competency_id')
        ->select(
            'ccp_weights.competency_id',
            'ccp_weights.weight'
        )
        ->selectRaw('AVG(scores.score) AS average_score')
        ->selectRaw('
            CASE
                WHEN AVG(scores.score) >= 15 THEN "Faible"
                WHEN AVG(scores.score) >= 10 THEN "Moyenne"
                ELSE "Élevée"
            END AS difficulte
        ')
        ->groupBy('ccp_weights.competency_id', 'ccp_weights.weight')
        ->get();

    // Données pour graphique radar
    $ccpLabels   = $ccpAnalysis->pluck('competency.title');
    $ccpAverages = $ccpAnalysis->pluck('average_score');
    $ccpWeights  = $ccpAnalysis->pluck('weight');

    /** ---------------------------------------------------------
     *  📈 7. Données statistiques des sessions (graphique)
     * --------------------------------------------------------*/
    $sessionsData   = ExamSession::withCount('candidates')->orderBy('created_at')->get();
    $sessionsLabels = $sessionsData->pluck('name');
    $sessionsCounts = $sessionsData->pluck('candidates_count');

    /** ---------------------------------------------------------
     *  📤 8. Envoi des données à la vue
     * --------------------------------------------------------*/
    return view('admin.dashboard.admin', compact(
        'totalCandidates', 'totalSessions', 'totalCentres', 'totalJurys',
        'topCentres', 'recentCandidates', 'allSessions', 'selectedSession',
        'sessionsLabels', 'sessionsCounts',
        'ccpAnalysis', 'ccpLabels', 'ccpAverages', 'ccpWeights'
    ));
}


    /**
     * 📌 Dashboard Ministère
     */
    public function ministere(Request $request)
    {
        $sessionId = $request->input('session_id');
        $selectedSession = $sessionId ? ExamSession::find($sessionId) : null;

        $allSessions = ExamSession::orderBy('start_date','desc')->get();

        $candidatesQuery = Candidate::query();
        if ($selectedSession) $candidatesQuery->where('exam_session_id', $selectedSession->id);

        $totalCandidates = $candidatesQuery->count();
        $totalSessions   = ExamSession::count();
        $totalCentres    = Centre::count();
        $totalJurys      = User::where('role','jury')->count();

        $topCentres = Centre::withCount(['candidates' => function($q) use ($selectedSession) {
            if ($selectedSession) $q->where('exam_session_id', $selectedSession->id);
        }])->orderByDesc('candidates_count')->take(5)->get();

        $recentCandidates = $candidatesQuery->with(['examSession','centre'])->latest()->take(10)->get();

        $sessionsData   = ExamSession::withCount('candidates')->orderBy('created_at','asc')->get();
        $sessionsLabels = $sessionsData->pluck('name');
        $sessionsCounts = $sessionsData->pluck('candidates_count');

        return view('admin.dashboard.ministere', compact(
            'totalCandidates','totalSessions','totalCentres','totalJurys',
            'topCentres','recentCandidates','allSessions','selectedSession',
            'sessionsLabels','sessionsCounts'
        ));
    }

    /**
     * 📌 Dashboard Centre
     */
    public function centre()
    {
        $user = auth()->user();
        $centre = $user->centre;

        if (!$centre) {
            // return redirect()->route('admin.dashboard.centre')
                // ->with('error', "Aucun centre associé.");
        }

        $totalCandidates = Candidate::where('centre_id', $centre->id)->count();
        $totalSessions   = ExamSession::where('centre_id', $centre->id)->count();
        $totalJurys      = User::where('role','jury')
                               ->where('centre_id',$centre->id)
                               ->count();

        $pendingScores = Candidate::where('centre_id',$centre->id)
                                  // ->whereNull('score')
                                  ->count();

        $sessionsData = ExamSession::where('centre_id',$centre->id)
            ->withCount('candidates')
            ->orderBy('start_date')
            ->get();

        $statusStats = Candidate::where('centre_id',$centre->id)
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total','status');

        // Définir $ranking pour le chart
        $ranking = $centre->candidates()
            ->select('first_name', 'last_name', 'attendance_rate')
            ->get()
            ->map(function($candidate) {
                return (object)[
                    'name' => $candidate->first_name . ' ' . $candidate->last_name,
                    'attendance_rate' => $candidate->attendance_rate ?? 0,
                ];
            });


        return view('admin.dashboard.centre', [
            'centre'          => $centre,
            'totalCandidates' => $totalCandidates,
            'totalSessions'   => $totalSessions,
            'totalJurys'      => $totalJurys,
            'pendingScores'   => $pendingScores,
            'sessionsLabels'  => $sessionsData->pluck('name'),
            'sessionsCounts'  => $sessionsData->pluck('candidates_count'),
            'statusStats'     => $statusStats,
            'ranking' // <- il faut absolument passer ça
        ]);
    }

    /**
     * 📊 Comparaison des centres
     */
    public function centres()
    {
        $centres = Centre::withCount([
            'candidates',
            'examSessions'
        ])->get();

        $centresKpi = $centres->map(function ($centre) {

            $present = Candidate::where('centre_id',$centre->id)
                ->where('status','present')->count();

            $absent = Candidate::where('centre_id',$centre->id)
                ->where('status','absent')->count();

            $pendingScores = Candidate::where('centre_id',$centre->id)
                ->whereNull('score')->count();

            $attendanceRate = $centre->candidates_count > 0
                ? round(($present * 100) / $centre->candidates_count, 1)
                : 0;

        // Définir $ranking pour le chart
        $ranking = $centre->candidates()
            ->select('first_name', 'last_name', 'attendance_rate')
            ->get()
            ->map(function($candidate) {
                return (object)[
                    'name' => $candidate->first_name . ' ' . $candidate->last_name,
                    'attendance_rate' => $candidate->attendance_rate ?? 0,
                ];
            });

            return [
                'name'            => $centre->name,
                'candidates'      => $centre->candidates_count,
                'sessions'        => $centre->exam_sessions_count,
                'present'         => $present,
                'absent'          => $absent,
                'attendance_rate' => $attendanceRate,
            'ranking', // <- il faut absolument passer ça
                'pending_scores'  => $pendingScores,
            ];
        });

        $ranking = $centresKpi->sortByDesc('attendance_rate')->values();

        // return view('admin.dashboard.centres', compact(
        //     'centresKpi',
        //     'ranking'
        // ));
    }

    /**
     * 📌 Dashboard Jury
     */
    public function jury()
    {
        $jury = auth()->user();

        $sessionsData = ExamSession::whereHas('candidates', fn($q) => $q->where('jury_id',$jury->id))
            ->withCount(['candidates' => fn($q) => $q->where('jury_id',$jury->id)])
            ->orderBy('created_at','asc')->get();

        $totalCandidates  = Candidate::where('jury_id',$jury->id)->count();
        $totalSessions    = ExamSession::whereHas('candidates', fn($q) => $q->where('jury_id',$jury->id))->count();
        $validatedScores  = Candidate::where('jury_id',$jury->id)->whereNotNull('created_at')->count();

        $sessionsLabels = $sessionsData->pluck('name');
        $sessionsCounts = $sessionsData->pluck('candidates_count');

        return view('admin.dashboard.jury', compact(
            'totalCandidates','totalSessions','validatedScores','sessionsLabels','sessionsCounts'
        ));
    }

    /**
     * 📌 Dashboard Étudiant
     */
    public function student()
    {
        $student = auth()->user();

        $candidates = Candidate::with(['examSession.exam'])
            ->where('student_id', $student->id)
            ->get();

        $totalSessions = $candidates->count();
        $admis = $candidates->where('status', 'admis')->count();
        $ajourne = $candidates->where('status', 'ajourné')->count();

        $sessionsLabels = $candidates->pluck('examSession.name');
        $sessionsAverages = $candidates->map(fn($c) =>
            $c->calculateFinalAverage($c->exam_session_id)
        );

        return view('admin.dashboard.student', compact(
            'candidates',
            'student',
            'totalSessions',
            'admis',
            'ajourne',
            'sessionsLabels',
            'sessionsAverages'
        ));
    }

}
