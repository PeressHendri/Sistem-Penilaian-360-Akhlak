<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\IndicatorController;
use App\Http\Controllers\ReviewerController;
use App\Http\Controllers\ResultController;

// Admin Controllers
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminLogController;

// HC Controllers
use App\Http\Controllers\HCDashboardController;
use App\Http\Controllers\HCOrganizationController;
use App\Http\Controllers\HCProgramController;
use App\Http\Controllers\HCWeightController;
use App\Http\Controllers\HCTalentController;
use App\Http\Controllers\HCIdpController;

// Reviewer Controllers
use App\Http\Controllers\ReviewerDashboardController;
use App\Http\Controllers\ReviewerAssessmentController;

// Management Controllers
use App\Http\Controllers\ManagementDashboardController;
use App\Http\Controllers\ManagementAnalyticController;
use App\Http\Controllers\ManagementTalentController;
use App\Http\Controllers\ManagementEmployeeDetailController;
use App\Http\Controllers\ScoreController;
use App\Http\Controllers\SubmitController;

// Redirect root to login
Route::get('/', function () {
    return redirect('/login');
});

// Auth Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Multi-Role Routes
Route::middleware(['auth'])->group(function () {
    
    // Generic /dashboard redirects user depending on their Spatie role
    Route::get('/dashboard', [AuthController::class, 'showLoginForm'])->name('dashboard');

    Route::get('/scores', [ScoreController::class, 'index'])->name('scores.index');
    Route::post('/scores', [ScoreController::class, 'store'])->name('scores.store');
    Route::get('/submit', [SubmitController::class, 'index'])->name('submit.index');
    Route::post('/submit', [SubmitController::class, 'store'])->name('submit.store');

    // ─── ADMINISTRATOR GROUP ──────────────────────────────────────────
    Route::middleware(['role:Administrator'])->prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
        
        Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
        Route::post('/users', [UserController::class, 'store'])->name('admin.users.store');
        Route::put('/users/{id}', [UserController::class, 'update'])->name('admin.users.update');
        Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');
        
        Route::get('/roles', [RolePermissionController::class, 'index'])->name('admin.roles.index');
        Route::post('/roles', [RolePermissionController::class, 'store'])->name('admin.roles.store');
        Route::get('/permissions', [RolePermissionController::class, 'index'])->name('admin.permissions.index');
        
        Route::get('/logs', [AdminLogController::class, 'index'])->name('admin.logs.index');
    });

    // ─── HUMAN CAPITAL GROUP ──────────────────────────────────────────
    Route::middleware(['role:Human Capital|Administrator'])->prefix('hc')->group(function () {
        Route::get('/dashboard', [HCDashboardController::class, 'index'])->name('hc.dashboard');
        
        Route::get('/employees', [EmployeeController::class, 'index'])->name('hc.employees.index');
        Route::post('/employees', [EmployeeController::class, 'store'])->name('hc.employees.store');
        Route::put('/employees/{id}', [EmployeeController::class, 'update'])->name('hc.employees.update');
        Route::delete('/employees/{id}', [EmployeeController::class, 'destroy'])->name('hc.employees.destroy');
        Route::post('/employees/import', [EmployeeController::class, 'importExcel'])->name('hc.employees.import');

        Route::get('/organization-chart', [HCOrganizationController::class, 'index'])->name('hc.org.index');
        
        Route::get('/programs', [HCProgramController::class, 'index'])->name('hc.programs.index');
        Route::post('/programs', [HCProgramController::class, 'store'])->name('hc.programs.store');
        Route::put('/programs/{id}', [HCProgramController::class, 'update'])->name('hc.programs.update');
        
        Route::get('/indicators', [IndicatorController::class, 'index'])->name('hc.indicators.index');
        Route::post('/indicators', [IndicatorController::class, 'update'])->name('hc.indicators.update');
        
        Route::get('/weights', [HCWeightController::class, 'index'])->name('hc.weights.index');
        Route::post('/weights', [HCWeightController::class, 'store'])->name('hc.weights.store');
        
        Route::get('/reviewers', [ReviewerController::class, 'index'])->name('hc.reviewers.index');
        Route::post('/reviewers/generate', [ReviewerController::class, 'generateReviewers'])->name('hc.reviewers.generate');
        Route::post('/reviewers/notify', [ReviewerController::class, 'sendManualNotification'])->name('hc.reviewers.notify');
        
        Route::get('/results', [ResultController::class, 'index'])->name('hc.results.index');
        Route::get('/talent-mapping', [HCTalentController::class, 'index'])->name('hc.talent.index');
        Route::get('/idp', [HCIdpController::class, 'index'])->name('hc.idp.index');
        Route::post('/idp', [HCIdpController::class, 'store'])->name('hc.idp.store');
    });

    // ─── REVIEWER GROUP ──────────────────────────────────────────────
    Route::middleware(['role:Penilai|Administrator'])->prefix('reviewer')->group(function () {
        Route::get('/dashboard', [ReviewerDashboardController::class, 'index'])->name('reviewer.dashboard');
        Route::get('/assessments', [ReviewerAssessmentController::class, 'index'])->name('reviewer.assessments.index');
        Route::get('/assessments/{id}', [ReviewerAssessmentController::class, 'showForm'])->name('reviewer.assessments.form');
        Route::post('/assessments/{id}/save', [ReviewerAssessmentController::class, 'saveDraft'])->name('reviewer.assessments.save');
        Route::post('/assessments/{id}/submit', [ReviewerAssessmentController::class, 'submitAssessment'])->name('reviewer.assessments.submit');
        Route::get('/summary/{id}', [ReviewerAssessmentController::class, 'showSummary'])->name('reviewer.assessments.summary');
    });

    // ─── MANAGEMENT GROUP ────────────────────────────────────────────
    Route::middleware(['role:Management|Administrator'])->prefix('management')->group(function () {
        Route::get('/dashboard', [ManagementDashboardController::class, 'index'])->name('management.dashboard');
        Route::get('/analytics', [ManagementAnalyticController::class, 'index'])->name('management.analytics.index');
        Route::get('/ranking', [ManagementDashboardController::class, 'ranking'])->name('management.ranking');
        Route::get('/talent-mapping', [ManagementTalentController::class, 'index'])->name('management.talent.index');
        Route::get('/employees/{id}', [ManagementEmployeeDetailController::class, 'index'])->name('management.employees.detail');
    });

});

