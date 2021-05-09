<?php

use Illuminate\Support\Facades\Route;
use TCG\Voyager\Facades\Voyager;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::redirect('/', 'login');

// Routes secured by authentication
Route::group(['middleware' => 'auth'], function() {
    Route::get('/dashboard', \App\Http\Controllers\DashboardController::class)->name('dashboard');

//    Route::post('/logout_other_devices', \App\Http\Controllers\Auth\LogoutOtherDevicesController::class)->name('logout_other_devices');
//    Route::post('/change_password', \App\Http\Controllers\Auth\ChangePasswordController::class)->name('change_password');
    Route::post('/password/change', \App\Http\Controllers\Auth\ChangePasswordController::class)->name('password.change');
    Route::get('/settings',\App\Http\Controllers\SettingsController::class)->name('settings');

    Route::get('/projects/assigned', [\App\Http\Controllers\ProjectController::class,'assigned'])->name('projects.assigned');
    Route::get('/projects/office', [\App\Http\Controllers\ProjectController::class,'office'])->name('projects.office');
    Route::get('/projects/own', [\App\Http\Controllers\ProjectController::class,'own'])->name('projects.own');

    Route::post('/projects/{project}/subprojects', [\App\Http\Controllers\SubprojectController::class, 'store'])->name('subprojects.store');
    Route::get('/projects/{project}/subprojects', [\App\Http\Controllers\SubprojectController::class, 'index'])->name('subprojects.index');
    Route::get('/projects/{project}/subprojects/create', [\App\Http\Controllers\SubprojectController::class, 'create'])->name('subprojects.create');

    Route::get('/projects/{project}/trip/edit', [\App\Http\Controllers\TripController::class,'edit'])->name('trips.edit');
    Route::get('/projects/{project}/trip/create', [\App\Http\Controllers\TripController::class,'create'])->name('trips.create');
    Route::get('/projects/{project}/trip', [\App\Http\Controllers\TripController::class,'show'])->name('trips.show');
    Route::put('/projects/{project}/trip', [\App\Http\Controllers\TripController::class,'update'])->name('trips.update');
    Route::post('/projects/{project}/trip', [\App\Http\Controllers\TripController::class,'store'])->name('trips.store');

    Route::get('/trips', [\App\Http\Controllers\TripController::class, 'index'])->name('trips.index');
});

// Resources secured by auth
Route::middleware('auth')->group(function () {
    Route::resources([
        'projects'      => \App\Http\Controllers\ProjectController::class,
        'reviews'       => \App\Http\Controllers\ReviewController::class,
        'subprojects'   =>  \App\Http\Controllers\SubprojectController::class,
    ]);
});

// auth routes with registration disabled

// Admin routes
Route::middleware('admin')->prefix('/admin')->name('admin.')->group(function () {
    Route::get('', \App\Http\Controllers\Admin\AdminController::class)->name('index');
    Route::resources([
        'approval_levels'       => \App\Http\Controllers\Admin\ApprovalLevelController::class,
        'bases'                 =>  \App\Http\Controllers\Admin\BasisController::class,
        'cip_types'             =>  \App\Http\Controllers\Admin\CipTypeController::class,
        'fs_statuses'           => \App\Http\Controllers\Admin\FsStatusController::class,
        'funding_institutions'  =>  \App\Http\Controllers\Admin\FundingInstitutionController::class,
        'funding_sources'       => \App\Http\Controllers\Admin\FundingSourceController::class,
        'gads'                  => \App\Http\Controllers\Admin\GadController::class,
        'implementation_modes'  => \App\Http\Controllers\Admin\ImplementationModeController::class,
        'infrastructure_sectors'=> \App\Http\Controllers\Admin\InfrastructureSectorController::class,
        'infrastructure_subsectors'=> \App\Http\Controllers\Admin\InfrastructureSubsectorController::class,
        'offices'               => \App\Http\Controllers\Admin\OfficeController::class,
        'operating_units'       => \App\Http\Controllers\Admin\OperatingUnitController::class,
        'operating_unit_types'  => \App\Http\Controllers\Admin\OperatingUnitTypeController::class,
        'pap_types'             => \App\Http\Controllers\Admin\PapTypeController::class,
        'pdp_chapters'          => \App\Http\Controllers\Admin\PdpChapterController::class,
        'pdp_indicators'        => \App\Http\Controllers\Admin\PdpIndicatorController::class,
        'permissions'           => \App\Http\Controllers\Admin\PermissionController::class,
        'pip_typologies'        => \App\Http\Controllers\Admin\PipTypologyController::class,
        'preparation_documents' => \App\Http\Controllers\Admin\PreparationDocumentController::class,
        'prerequisites'         => \App\Http\Controllers\Admin\PrerequisiteController::class,
        'project_statuses'      => \App\Http\Controllers\Admin\ProjectStatusController::class,
        'readiness_levels'      => \App\Http\Controllers\Admin\ReadinessLevelController::class,
        'regions'               => \App\Http\Controllers\Admin\RegionController::class,
        'roles'                 => \App\Http\Controllers\Admin\RoleController::class,
        'sdgs'                  => \App\Http\Controllers\Admin\SdgController::class,
        'spatial_coverages'     => \App\Http\Controllers\Admin\SpatialCoverageController::class,
        'ten_point_agendas'     => \App\Http\Controllers\Admin\TenPointAgendaController::class,
        'tiers'                 => \App\Http\Controllers\Admin\TierController::class,
        'users'                 => \App\Http\Controllers\Admin\UserController::class,
        'projects'              => \App\Http\Controllers\Admin\AdminProjectController::class,
        'projects.users'        => \App\Http\Controllers\Admin\ProjectUserController::class,
        'teams'                 => \App\Http\Controllers\Admin\TeamController::class,
    ]);
});

Auth::routes(['register' => false]);

Route::group(['middleware' => 'guest'], function() {
    Route::get('/auth/google', [\App\Http\Controllers\Auth\SocialLoginController::class,'redirectToGoogle'])->name('auth.google');
    Route::get('/auth/google/callback', [\App\Http\Controllers\Auth\SocialLoginController::class,'handleGoogleCallback'])->name('auth.google-callback');
});

Route::get('email', function () {
    $user = new App\Models\User(['email' => 'mlab817@gmail.com']);
    Mail::to($user)->send(new \App\Mail\TestEmail());
    \Illuminate\Support\Facades\Log::info('email sent');

});

Route::fallback(function () {
    return view('errors.404');
});
