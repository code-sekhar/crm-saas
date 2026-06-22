<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeadController;
use App\Models\Lead;
use App\Http\Controllers\TaskController;
use App\Models\Task;

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

    return view('dashboard', compact(
        'totalLeads',
        'newLeads',
        'wonLeads',
        'lostLeads',
        'recentLeads',
        'pendingTasks'
    ));

})->middleware(['auth'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
