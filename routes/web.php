<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PonyController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', function () {
    return view('auth/login');
});


Route::middleware('auth')->group(function () {
    Route::get('appointments/all', [AppointmentController::class, 'all'])->name('appointments.all');
    Route::post('appointments/assign', [AppointmentController::class, 'assign'])->name('appointments.assign');
    Route::post('appointments/validatePonyCount', [AppointmentController::class, 'validatePonyCount'])->name('appointments.validatePonyCount');
//Route::post('appointments/validateEmployeeCount', [AppointmentController::class, 'validateEmployeeCount'])->name('appointments.validateEmployeeCount');
    Route::resource('appointments', AppointmentController::class);


    Route::resource('clients', ClientController::class);
    Route::resource('ponies', PonyController::class);
    Route::resource('employees', EmployeeController::class);
    Route::resource('invoices', InvoiceController::class);
    Route::get('invoices/summary/{month}', [InvoiceController::class, 'summary']);
    Route::get('invoices/downloadPDF/{id}', [InvoiceController::class, 'downloadPDF'])->name('invoices.downloadPDF');
    Route::post('/invoices/sendCurrentMonth', [InvoiceController::class, 'sendCurrentMonth'])->name('invoices.sendCurrentMonth');
    Route::resource('groups', GroupController::class);

});

Route::middleware(['adminOnly'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


});


Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/appointments/today', [AppointmentController::class, 'today'])->middleware(['auth', 'verified'])->name('appointments.today');

require __DIR__.'/auth.php';
