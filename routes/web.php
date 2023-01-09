<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PanunoteController;
use App\Http\Controllers\FirebaseController;

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
Route::get('/', function () {
    return view('pages.auth.panunote_login');
})->name('/');

Route::get('/verify', App\Http\Livewire\PanunoteVerify::class)->name('verify')->middleware('islogin');

Route::post('signin', [FirebaseController::class, 'signIn'])->name('signin'); 
Route::post('signup', [FirebaseController::class, 'signUp'])->name('signup');

Route::get('/insert', [FirebaseController::class, 'insert'])->name('insert'); 

Route::post('/newnote/{id}', [FirebaseController::class, 'newnote'])->name('newnote'); 
Route::post('/newsubject', [FirebaseController::class, 'newsubject'])->name('newsubject');
Route::post('/savenote', [FirebaseController::class, 'savenote'])->name('savenote'); 


Route::get('/display', [FirebaseController::class, 'display'])->name('display'); 
Route::get('/signout', [FirebaseController::class, 'signOut'])->name('signout');


Route::post('/recover', [PanunoteController::class, 'recover'])->name('recover');

Route::get('/forgot', [PanunoteController::class, 'forgot'])->name('forgot');

Route::get('/login', [PanunoteController::class, 'login'])->name('login')->middleware('islogin');
Route::get('/register', [PanunoteController::class, 'register'])->name('register');

Route::get('/subjects/{subject_id}/{note_id}', App\Http\Livewire\PanunoteNote::class)->name('note')->middleware('islogin');
Route::get('/subjects/{subject_id}', App\Http\Livewire\PanunoteSubject::class)->name('subject')->middleware('islogin');
Route::get('/subjects', App\Http\Livewire\PanunoteSubjects::class)->name('subjects')->middleware('islogin');
Route::get('/quizzes', App\Http\Livewire\PanunoteQuizzes::class)->name('quizzes')->middleware('islogin');
Route::get('/quizzes/{quiz_id}', App\Http\Livewire\PanunoteQuizz::class)->name('quiz')->middleware('islogin');

Route::get('/quiz/{quiz_id}', App\Http\Livewire\PanunoteTakeQuiz::class)->name('takequiz');

Route::get('/{user_name}/subjects/{subject_id}', App\Http\Livewire\PanunoteSubjectPublic::class)->name('subject_public')->middleware('islogin'); 
Route::get('/{user_name}/subjects/{subject_id}/{note_id}', App\Http\Livewire\PanunoteNotePublic::class)->name('note_public')->middleware('islogin');
Route::get('/{user_name}/quizzes/{quiz_id}', App\Http\Livewire\PanunoteQuizPublic::class)->name('quizz_public')->middleware('islogin');

Route::get('/settings', App\Http\Livewire\PanunoteSettings::class)->name('settings')->middleware('islogin');

//Route::get('/browse/subjects', App\Http\Livewire\PanunoteBrowseSubject::class)->name('browse_subjects')->middleware('islogin');
Route::get('/community', App\Http\Livewire\PanunoteBrowseNotes::class)->name('community')->middleware('islogin');
//Route::get('/browse/quizzes', App\Http\Livewire\PanunoteBrowseQuizzes::class)->name('browse_quizzes')->middleware('islogin');

Route::get('/favorites', App\Http\Livewire\PanunoteFavorites::class)->name('favorites')->middleware('islogin');
Route::get('/shared', App\Http\Livewire\PanunoteShared::class)->name('shared')->middleware('islogin');

Route::get('/panugame', App\Http\Livewire\PanunoteGamification::class)->name('panugame')->middleware('islogin');
Route::get('/panugame/create', App\Http\Livewire\PanunoteGamificationCreate::class)->name('create')->middleware('islogin');
Route::get('/panugame/join', App\Http\Livewire\PanunoteGamificationJoin::class)->name('join')->middleware('islogin');
Route::get('/lobby/{game_id}', App\Http\Livewire\PanunoteGamificationGame::class)->name('thegame')->middleware('islogin');
Route::get('/panugame/{game_id}', App\Http\Livewire\PanunoteGamificationStart::class)->name('game_start')->middleware('islogin');

Route::get('/analytics', App\Http\Livewire\PanunoteAnalytics::class)->name('analytics')->middleware('islogin');

//Route::get('/subjects/{id}', [PanunoteController::class, 'subject'])->name('subject'); 
//Route::get('/subjects/{subject_id}/{note_id}', [PanunoteController::class, 'note'])->name('note'); 

Route::get('/dictionary', App\Http\Livewire\PanunoteDictionary::class)->name('dictionary')->middleware('islogin');

// Route::get('/test', [PanunoteController::class, 'test'])->name('test');

Route::get('/reset', App\Http\Livewire\ForgotPassword::class)->name('reset');
// Route::get('/get_questions', [PanunoteController::class, 'get_questions'])->name('get_questions');

