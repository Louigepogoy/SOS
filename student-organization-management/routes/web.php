<?php

use App\Http\Controllers\Admin\MembershipController as AdminMembershipController;
use App\Http\Controllers\Admin\OrganizationController as AdminOrganizationController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Officer\AnnouncementController as OfficerAnnouncementController;
use App\Http\Controllers\Officer\EventController as OfficerEventController;
use App\Http\Controllers\Officer\MembershipController as OfficerMembershipController;
use App\Http\Controllers\Officer\OrganizationController as OfficerOrganizationController;
use App\Http\Controllers\Officer\ReportController as OfficerReportController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Student\AnnouncementController;
use App\Http\Controllers\Student\EventController;
use App\Http\Controllers\Student\OrganizationController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Auth::routes(['verify' => true]);

Route::middleware(['auth', 'verified', 'active'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::middleware('role:student')->prefix('student')->name('student.')->group(function () {
        Route::get('/organizations', [OrganizationController::class, 'index'])->name('organizations.index');
        Route::get('/organizations/{organization}', [OrganizationController::class, 'show'])->name('organizations.show');
        Route::post('/organizations/{organization}/join', [OrganizationController::class, 'join'])->name('organizations.join');
        Route::post('/organizations/{organization}/leave', [OrganizationController::class, 'leave'])->name('organizations.leave');
        Route::post('/memberships/{membership}/cancel', [OrganizationController::class, 'cancel'])->name('memberships.cancel');
        Route::get('/memberships', [OrganizationController::class, 'memberships'])->name('memberships.index');
        Route::get('/events', [EventController::class, 'index'])->name('events.index');
        Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements.index');
    });

    Route::middleware('role:officer')->prefix('officer')->name('officer.')->group(function () {
        Route::get('/organization', [OfficerOrganizationController::class, 'edit'])->name('organization.edit');
        Route::put('/organization', [OfficerOrganizationController::class, 'update'])->name('organization.update');
        Route::get('/memberships', [OfficerMembershipController::class, 'index'])->name('memberships.index');
        Route::get('/memberships/{membership}', [OfficerMembershipController::class, 'show'])->name('memberships.show');
        Route::post('/memberships/{membership}/approve', [OfficerMembershipController::class, 'approve'])->name('memberships.approve');
        Route::post('/memberships/{membership}/reject', [OfficerMembershipController::class, 'reject'])->name('memberships.reject');
        Route::resource('events', OfficerEventController::class)->except(['show']);
        Route::resource('announcements', OfficerAnnouncementController::class)->except(['show', 'edit', 'update']);
        Route::get('/reports', [OfficerReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/export', [OfficerReportController::class, 'export'])->name('reports.export');
    });

    Route::middleware('role:super_admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [AdminUserController::class, 'create'])->name('users.create');
        Route::post('/users', [AdminUserController::class, 'store'])->name('users.store');
        Route::get('/users/{user}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('users.update');
        Route::post('/users/{user}/toggle', [AdminUserController::class, 'toggleStatus'])->name('users.toggle');
        Route::resource('organizations', AdminOrganizationController::class)->except(['show', 'destroy']);
        Route::post('/organizations/{organization}/approve', [AdminOrganizationController::class, 'approve'])->name('organizations.approve');
        Route::post('/organizations/{organization}/reject', [AdminOrganizationController::class, 'reject'])->name('organizations.reject');
        Route::get('/memberships', [AdminMembershipController::class, 'index'])->name('memberships.index');
        Route::get('/memberships/{membership}', [AdminMembershipController::class, 'show'])->name('memberships.show');
        Route::post('/memberships/{membership}/approve', [AdminMembershipController::class, 'approve'])->name('memberships.approve');
        Route::post('/memberships/{membership}/reject', [AdminMembershipController::class, 'reject'])->name('memberships.reject');
        Route::get('/reports', [AdminReportController::class, 'index'])->name('reports.index');
        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');
    });
});
