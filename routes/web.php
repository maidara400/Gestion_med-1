<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers as C;
use App\Http\Controllers\MedecinController;


Route::get('/', function () {
    return view('welcome');
});

// Route::get('/', [C\AuthController::class, 'showLogin'])->name('login');
Route::get('/register', [C\AuthController::class, 'showRegister']);
Route::post('/register', [C\AuthController::class, 'register'])->name('register');




// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    // Route::middleware(['auth', 'role:admin'])->group(function () {
    // Route::get('/dashboard/admin', function () {
    //     return view('dashboard.dashboardAdmin');
    // });
   
});


require __DIR__.'/auth.php';








// Route::prefix('test')->group(function () {

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard/admin', function () {
        return view('dashboard.dashboardAdmin');
    });
    // Route::get('/admin/services', [C\AdminServiceController::class, 'index']);
    // Route::get('/admin/users', [C\AdminUserController::class, 'index']);
});
Route::middleware(['auth', 'role:medecin'])->group(function () {
    Route::get('/dashboard/medecin', function () {
        return view('dashboard.dashboardMedecin');
    });
});

Route::middleware(['auth', 'role:patient'])->group(function () {
    Route::get('/dashboard/dashboardPatient', function () {return view('dashboard.patient');
    });
});


Route::get('/dashboard', [C\DashboardController::class, 'index'])->middleware('auth')->name('dashboard');


Route::get('/services/{id}', [C\ServiceController::class, 'show']);
Route::get('/services', [C\ServiceController::class, 'index']);

// Authentication Routes
Route::get('/login', [C\AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [C\AuthController::class, 'login']);
Route::post('/logout', [C\AuthController::class, 'logout'])->name('logout')->middleware('auth');






















Route::prefix('medecin')
    ->middleware(['auth', 'role:admin'])
    ->controller(\App\Http\Controllers\MedecinController::class)
    ->name('medecin.')
    ->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::post('/store', 'store')->name('store');
    Route::get('/edit/{id}', 'edit')->name('edit');
    Route::put('/update/{id}', 'update')->name('update');
    Route::delete('/delete/{id}', 'destroy')->name('delete');
});




// });
