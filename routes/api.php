<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\{
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
    SessionDocumentController
};
use App\Http\Controllers\API\AuthController;

Route::prefix('api')->group(function () {

    // --------------------------
    // Auth API
    // --------------------------
    Route::post('login', [AuthController::class, 'login']);
    Route::middleware('auth:sanctum')->post('logout', [AuthController::class, 'logout']);
    Route::middleware('auth:sanctum')->get('user', function () { return auth()->user(); });

    Route::middleware('auth:sanctum')->group(function () {

        // --------------------------
        // Dashboards API
        // --------------------------
        Route::get('dashboard/admin', [DashboardController::class, 'admin']);
        Route::get('dashboard/ministere', [DashboardController::class, 'ministere']);
        Route::get('dashboard/centre', [DashboardController::class, 'centre']);
        Route::get('dashboard/jury', [DashboardController::class, 'jury']);
        Route::get('dashboard/student', [DashboardController::class, 'student']);

        // --------------------------
        // Candidates API
        // --------------------------
        Route::apiResource('candidates', CandidateController::class);
        Route::post('candidates/{candidate}/status', [CandidateController::class, 'updateStatus']);
        Route::get('centres/{centre}/candidates', [CandidateController::class, 'indexForCentre']);
        Route::get('exam_sessions/{exam_session}/candidates', [CandidateController::class, 'indexForSession']);

        // Import / Export
        Route::post('centres/{centre}/candidates/import', [CandidateController::class, 'import']);
        Route::get('centres/{centre}/candidates/export', [CandidateController::class, 'export']);

        // --------------------------
        // Centres API
        // --------------------------
        Route::apiResource('centres', CenterController::class);
        Route::get('centres/{centre}/exams', [CenterController::class, 'showExams']);

        // --------------------------
        // Exams & Sessions
        // --------------------------
        Route::apiResource('exams', ExamController::class);
        Route::get('exams/{exam}/edit', [ExamUController::class, 'edit']);
        Route::put('exams/{exam}', [ExamUController::class, 'update']);
        Route::apiResource('exam_sessions', ExamSessionController::class);
        Route::get('exam_sessions/{exam_session}/showM', [ExamUController::class, 'showM']);
        Route::get('exam_sessions/{exam_session}/documents', [CandidateDocumentController::class, 'indexForSession']);
        Route::post('exam_sessions/{examSession}/documents', [SessionDocumentController::class, 'store']);
        Route::delete('documents/{document}', [SessionDocumentController::class, 'destroy']);

        // --------------------------
        // Scores API
        // --------------------------
        Route::apiResource('scores', ScoreController::class)->except(['show','destroy']);
        Route::get('exam_sessions/{exam_session}/scores', [ScoreController::class, 'indexForSession']);
        Route::post('scores/{score}/validate', [ScoreController::class, 'validateScore']);

        // --------------------------
        // Results API
        // --------------------------
        Route::apiResource('results', ResultController::class)->only(['index', 'show']);
        Route::get('results/{result}/export', [ResultController::class, 'export']);

        // --------------------------
        // Procès-verbaux, Audit, Notifications
        // --------------------------
        Route::apiResource('pv', PvController::class)->only(['index','create','show']);
        Route::apiResource('audit', AuditController::class)->only(['index','show']);
        Route::apiResource('notifications', NotificationController::class)->only(['index','create','show']);

        // --------------------------
        // Users & Roles API
        // --------------------------
        Route::apiResource('users', UserController::class);
        Route::apiResource('roles', RoleController::class);

        // --------------------------
        // Competencies & CCP weights
        // --------------------------
        Route::apiResource('competencies', CompetencyController::class);
        Route::apiResource('ccp_weights', CcpWeightController::class)->except(['show']);
    });
});
