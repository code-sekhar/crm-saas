<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeadController;
use App\Models\Lead;
use App\Http\Controllers\TaskController;
use App\Models\Task;
use App\Models\FollowUp;
use App\Http\Controllers\LeadNoteController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\FollowUpController;
use Carbon\Carbon;


Route::get('/', function () {
    return view('welcome');
});

Route::resource(
    'leads',
    LeadController::class
)->middleware('auth');

Route::resource(
    'tasks',
    TaskController::class
)->middleware('auth');

Route::get('/dashboard', function () {

    $tenantId = auth()->user()->tenant_id;

    $totalLeads = Lead::where('tenant_id', $tenantId)->count();

    $newLeads = Lead::where('tenant_id', $tenantId)
        ->where('status', 'New')
        ->count();

    $wonLeads = Lead::where('tenant_id', $tenantId)
        ->where('status', 'Won')
        ->count();

    $lostLeads = Lead::where('tenant_id', $tenantId)
        ->where('status', 'Lost')
        ->count();

    $recentLeads = Lead::where('tenant_id', $tenantId)
        ->latest()
        ->take(5)
        ->get();
    $pendingTasks = Task::where(
            'tenant_id',
            auth()->user()->tenant_id
        )->where('status', 'Pending')
        ->count();

    // Follow-up Statistics
    $todayFollowUps = FollowUp::where('tenant_id', $tenantId)
        ->whereDate('follow_up_date', Carbon::today())
        ->where('status', 'Pending')
        ->count();

    $upcomingFollowUps = FollowUp::where('tenant_id', $tenantId)
        ->whereDate('follow_up_date', '>', Carbon::today())
        ->where('status', 'Pending')
        ->count();

    $overdueFollowUps = FollowUp::where('tenant_id', $tenantId)
        ->whereDate('follow_up_date', '<', Carbon::today())
        ->where('status', 'Pending')
        ->count();

    $completedFollowUps = FollowUp::where('tenant_id', $tenantId)
        ->where('status', 'Completed')
        ->count();

    return view('dashboard', compact(
        'totalLeads',
        'newLeads',
        'wonLeads',
        'lostLeads',
        'recentLeads',
        'pendingTasks',
        'todayFollowUps',
        'upcomingFollowUps',
        'overdueFollowUps',
        'completedFollowUps'
    ));

})->middleware(['auth'])->name('dashboard');
    Route::post('/lead-notes',[LeadNoteController::class,'store'])->middleware('auth')->name('lead-notes.store');
    Route::delete('/lead-notes/{leadNote}',[LeadNoteController::class, 'destroy'])->middleware('auth')->name('lead-notes.destroy');
    Route::put('/lead-notes/{leadNote}',[LeadNoteController::class,'update'])->middleware('auth')->name('lead-notes.update');
    Route::get(
      '/lead-notes/{leadNote}/edit',
            [LeadNoteController::class,'edit']
        )->middleware('auth')
        ->name('lead-notes.edit');

Route::resource('follow-ups', FollowUpController::class)->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/leads/{lead}', [LeadController::class, 'show'])
    ->name('leads.show');

});

require __DIR__.'/auth.php';
