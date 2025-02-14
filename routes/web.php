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
    return view('welcome');
});

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
Route::get('invoices/download/{id}', [InvoiceController::class, 'download'])->name('invoices.download');
Route::resource('groups', GroupController::class);


/*Route::get('appointments', [AppointmentController::class, 'index'])->name('appointments.index');
//Route::resource('appointments', AppointmentController::class);
Route::post('appointments/assign', [AppointmentController::class, 'assign'])->name('appointments.assign');
Route::get('appointments/all', [AppointmentController::class, 'all'])->name('appointments.all');
Route::get('appointments/store', [AppointmentController::class, 'store'])->name('appointments.store');
//Route::get('appointments/edit', [AppointmentController::class, 'edit'])->name('appointments.edit');
//Route::get('appointments/destroy', [AppointmentController::class, 'destroy'])->name('appointments.destroy');
Route::post('appointments', [AppointmentController::class, 'store'])->name('appointments.store');
Route::get('appointments/edit/{appointment}', [AppointmentController::class, 'edit'])->name('appointments.edit'); // Ajustement ici
Route::delete('appointments/destroy/{appointment}', [AppointmentController::class, 'destroy'])->name('appointments.destroy');
//Route::get('appointments/edit/{appointment}', [AppointmentController::class, 'update'])->name('appointments.update'); // Ajustement ici
Route::get('appointments/{appointment}', [AppointmentController::class, 'show'])->name('appointments.show');*/

Route::middleware('auth')->get('/test', function () {
    return 'Authenticated';
});



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
//    Route::get('appointments', [AppointmentController::class, 'index'])->name('appointments.index');
//    Route::get('appointments/all', [AppointmentController::class, 'all'])->name('appointments.all');
//    Route::get('appointments/{appointment}', [AppointmentController::class, 'show'])->name('appointments.show');
});

//Route::middleware(['role:admin'])->group(function () {
//    Route::resource('appointments', AppointmentController::class)->except(['index', 'show']);
//});
//Route::middleware(['role:staff', 'role:admin'])->group(function () {
//    Route::get('appointments', [AppointmentController::class, 'index'])->name('appointments.index');
//    Route::get('appointments/all', [AppointmentController::class, 'all'])->name('appointments.all');
//    Route::get('appointments/{appointment}', [AppointmentController::class, 'show'])->name('appointments.show');
//});

require __DIR__.'/auth.php';
