<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SchoolController;
use App\Models\School;
use App\Models\SelectedSchool;
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

Route::get('/dashboard', function () {
    $schools = SelectedSchool::where('user_id', Auth::user()->id)->first();
    if($schools){
        $selectedSchools = json_decode($schools->selected_school);
        $schools = School::WhereNotIn('id', $selectedSchools)->get();
    }else{
        $schools = School::all();
    }

    return view('dashboard',compact('schools'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/select-school', [SchoolController::class, 'schoolSelect'])->name('select.school');
    Route::get('/selected-school',[SchoolController::class,'selectedSchool'])->name('selected.school');
    Route::post('/remove-school',[SchoolController::class,'removeSchool'])->name('remove.school');
});

require __DIR__.'/auth.php';
