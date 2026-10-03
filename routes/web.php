<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{
    DashboardController,
    CenterController,
    ExamController,
    ExamSessionController,
    CompetencyController,
    CcpWeightController,
    CandidateController,
    CandidateDocumentController,
    ScoreController,
    ResultController,
    PvController,
    AuditController,
    NotificationController,
    UserController,
    RoleController,
    ExamUController,
    SessionDocumentController,
    ExamWeightController,
    GroupController,
};
use App\Http\Controllers\Auth\AuthenticatedSessionController;

/*
|--------------------------------------------------------------------------
| Page publique
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Authentification
|--------------------------------------------------------------------------
*/
Route::get('login', [AuthenticatedSessionController::class, 'create'])
    ->middleware('guest')->name('login');
Route::post('login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest');
Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')->name('logout');

Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/centres/{centre}/sessions', 
        [ExamSessionController::class, 'byCentre']
    )->name('admin.centres.sessions');
});

/*
|--------------------------------------------------------------------------
| Routes Admin
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->middleware('auth')->name('admin.')->group(function () {
    
    Route::resource('groups', GroupController::class);

    /*
    |--------------------------------------------------------------------------
    | Dashboards par rôle
    |--------------------------------------------------------------------------
    */
    Route::prefix('admin/dashboard')->middleware(['auth'])->group(function () {

        Route::get('/centre',
            [AdminDashboardController::class, 'centre']
        )->name('admin.dashboard.centre');

        Route::get('/centres',
            [AdminDashboardController::class, 'centres']
        )->name('admin.dashboard.centres');

    });

    Route::get('dashboard/admin', [DashboardController::class, 'admin'])->name('dashboard.admin');
    Route::get('dashboard/jury', [DashboardController::class, 'jury'])->name('dashboard.jury');
    Route::get('dashboard/ministere', [DashboardController::class, 'ministere'])->name('dashboard.ministere');
    Route::get('dashboard/centre', [DashboardController::class, 'centre'])->name('dashboard.centre');
    Route::get('dashboard/region', [DashboardController::class, 'region'])->name('dashboard.region');
    Route::get('dashboard/student', [DashboardController::class, 'student'])->name('dashboard.student');

    /*
    |--------------------------------------------------------------------------
    | Examens
    |--------------------------------------------------------------------------
    */
    // Routes CRUD via ExamController
    Route::resource('exams', ExamController::class);
    
    // Si besoin d'une mise à jour via ExamUController (évite le conflit avec admin.exams.update)
    Route::get('exams/{exam}/editU', [ExamUController::class, 'edit'])->name('examsU.edit');
    Route::put('exams/{exam}/updateU', [ExamUController::class, 'update'])->name('examsU.update');

    // CcpWeights pour un examen
    Route::get('exams/{exam}/ccp-weights', [CcpWeightController::class, 'edit'])->name('ccp.weights.edit');
    Route::post('exams/{exam}/ccp-weights', [CcpWeightController::class, 'update'])->name('ccp.weights.update');


    /*
    |--------------------------------------------------------------------------
    | Centres
    |--------------------------------------------------------------------------
    */
    Route::resource('centres', CenterController::class);
    Route::get('centers/{center}/exams', [CenterController::class, 'showExams'])->name('centers.exams');

    /*
    |--------------------------------------------------------------------------
    | Exam Sessions
    |--------------------------------------------------------------------------
    */
    Route::resource('exam_sessions', ExamSessionController::class);

    // Documents liés à une session
    Route::post('exam_sessions/{examSession}/documents', [SessionDocumentController::class, 'store'])
        ->name('exam_sessions.documents.store');
    Route::delete('documents/{document}', [SessionDocumentController::class, 'destroy'])
        ->name('documents.destroy');

    /*
    |--------------------------------------------------------------------------
    | Candidats & documents
    |--------------------------------------------------------------------------
    */
    // Routes globales
    Route::prefix('candidates')->name('candidates.')->group(function () {
        Route::get('/', [CandidateController::class, 'index'])->name('index');
        Route::get('/create', [CandidateController::class, 'create'])->name('create');
        Route::post('/', [CandidateController::class, 'store'])->name('store');
        Route::get('/{candidate}', [CandidateController::class, 'show'])->name('show');
        Route::get('/{candidate}/edit', [CandidateController::class, 'edit'])->name('edit');
        Route::put('/{candidate}', [CandidateController::class, 'update'])->name('update');
        Route::delete('/{candidate}', [CandidateController::class, 'destroy'])->name('destroy');
        Route::post('/{candidate}/status', [CandidateController::class, 'updateStatus'])->name('updateStatus');
    });

    // Routes par centre
    Route::prefix('centres/{centre}/candidates')->name('centres.candidates.')->group(function () {
        Route::get('/', [CandidateController::class, 'indexForCentre'])->name('index');
        Route::get('/create', [CandidateController::class, 'createForCentre'])->name('create');
        Route::post('/', [CandidateController::class, 'storeForCentre'])->name('store');
        Route::get('/{candidate}/edit', [CandidateController::class, 'edit'])->name('edit');
        Route::put('/{candidate}', [CandidateController::class, 'updateForCentre'])->name('update');
        Route::delete('/{candidate}', [CandidateController::class, 'destroy'])->name('destroy');

        // Import / Export Excel
        Route::get('/import', [CandidateController::class, 'importForm'])->name('import.form');
        Route::post('/import', [CandidateController::class, 'import'])->name('import');
        Route::get('/export', [CandidateController::class, 'export'])->name('export');
    });

    /*
    |--------------------------------------------------------------------------
    | Scores
    |--------------------------------------------------------------------------
    */
    Route::resource('scores', ScoreController::class)->except(['show', 'destroy']);
    Route::post('scores/{score}/validate', [ScoreController::class, 'validateScore'])->name('scores.validate');
    Route::post('scores/unlock', [ScoreController::class, 'unlockScore'])->middleware('can:unlock-scores')->name('scores.unlock');

    // Liste scores par session
    Route::get('exam_sessions/{exam_session}/scores', [ScoreController::class, 'indexForSession'])->name('sessions.scores');
    Route::get('exam_sessions/{exam_session}/candidates', [CandidateController::class, 'indexForSession'])->name('sessions.candidates');
    Route::get('exam_sessions/{exam_session}/documents', [CandidateDocumentController::class, 'indexForSession'])->name('sessions.documents');
    Route::get('scores/create', [ScoreController::class, 'create'])->name('scores.create');
    Route::get('exam_sessions/{exam_session}/showM', [ExamUController::class, 'showM'])->name('exam_sessions.showM');

    /*
    |--------------------------------------------------------------------------
    | Compétences
    |--------------------------------------------------------------------------
    */
    Route::resource('competencies', CompetencyController::class);

    /*
    |--------------------------------------------------------------------------
    | Résultats
    |--------------------------------------------------------------------------
    */
    Route::get('results/{session1}/{session2?}', [ResultController::class, 'index'])->name('results.index');
    Route::get('results/{session1}/pv/{session2?}', [ResultController::class, 'pv'])->name('results.pv');
    Route::post('results/recalculate/{session1}/{session2?}', [ResultController::class, 'recalculate'])->name('results.recalculate');
    Route::get('results/{result}/export', [ResultController::class, 'export'])->name('results.export');

    /*
    |--------------------------------------------------------------------------
    | Pondérations CCP
    |--------------------------------------------------------------------------
    */
    Route::resource('ccp_weights', CcpWeightController::class)->except(['show']);

    /*
    |--------------------------------------------------------------------------
    | Procès-verbaux
    |--------------------------------------------------------------------------
    */
    Route::resource('pv', PvController::class)->only(['index','create','show']);

    /*
    |--------------------------------------------------------------------------
    | Audit
    |--------------------------------------------------------------------------
    */
    Route::resource('audit', AuditController::class)->only(['index','show']);

    /*
    |--------------------------------------------------------------------------
    | Notifications
    |--------------------------------------------------------------------------
    */
    Route::resource('notifications', NotificationController::class)->only(['index','create','show']);

    /*
    |--------------------------------------------------------------------------
    | Utilisateurs & rôles
    |--------------------------------------------------------------------------
    */
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);

    Route::patch('/exams/{exam}/competencies/{competency}/weight', 
        [ExamWeightController::class, 'update']
    )->name('weights.update');

    // Route::resource('admin.groups', \App\Http\Controllers\Admin\GroupController::class);

    Route::resource('admin/groups', \App\Http\Controllers\Admin\GroupController::class)
     ->names('admin.groups');

    Route::patch('/exams/{exam}/weights', 
        [ExamWeightController::class, 'updateAll']
    )->name('weights.updateAll');


});
