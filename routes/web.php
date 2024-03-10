<?php
use App\Http\Controllers\AdminController,
App\Http\Controllers\AtributController,
App\Http\Controllers\ClassificationController,
App\Http\Controllers\NilaiAtributController,
App\Http\Controllers\ProbabilityController,
App\Http\Controllers\ResultController,
App\Http\Controllers\TestingDataController,
App\Http\Controllers\TrainingDataController,
Illuminate\Support\Facades\Route;

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
Route::controller(AdminController::class)->middleware(['guest'])->group(function () {
	Route::prefix('register')->name('register')->group(function () {
		Route::get('/', 'register');
		Route::post('/', 'postRegister')->middleware(['throttle:user'])->name('.post');
	});
	Route::prefix('login')->name('login')->group(function () {
		Route::get('/', 'login');
		Route::post('/', 'postLogin')->middleware(['throttle:user'])->name('.post');
	});
	Route::prefix('password')->name('password.')->group(function () {
		Route::get('/', 'forget')->name('forget');
		Route::post('/', 'forgetLink')->name('send');
		Route::prefix('reset')->group(function () {
			Route::get('/', 'showReset')->name('change');
			Route::patch('/', 'reset')->middleware(['throttle:user'])->name('reset');
		});
	});
});
Route::middleware(['auth'])->group(function () {
	Route::controller(AdminController::class)->group(function () {
		Route::get('/', 'index')->name('home');
		Route::prefix('profile')->name('profil.')->group(function () {
			Route::get('/', 'edit')->name('edit');
			Route::middleware(['throttle:user'])->group(function () {
				Route::patch('/', 'update')->name('update');
				Route::delete('/', 'delete')->name('delete');
			});
		});
		Route::post('/', 'logout')->name('logout');
	});
	Route::controller(TrainingDataController::class)->prefix('training')
		->name('training.')->group(function () {
			Route::get('count', 'count')->name('count')->block();
			Route::post('upload','import')->name('import')->block();
			Route::delete('/', 'clear')->name('clear')->block();
		});
	Route::controller(TestingDataController::class)->prefix('testing')
		->name('testing.')->group(function () {
			Route::get('count', 'count')->name('count')->block();
			Route::post('upload','import')->name('import')->block();
			Route::delete('/', 'clear')->name('clear')->block();
		});
	Route::controller(ProbabilityController::class)->prefix('probab')
		->name('probab.')->group(function () {
			Route::get('/', 'index')->name('index');
			Route::get('calc', 'create')->name('create');
			Route::delete('/', 'destroy')->name('reset');
		});
	Route::prefix('atribut')->name('atribut.')->group(function () {
		Route::get('count', [AtributController::class, 'count'])->name('count');
		Route::get('nilai/count', [NilaiAtributController::class, 'count'])
			->name('nilai.count');
		Route::resource('nilai', NilaiAtributController::class);
	});
	Route::resources([
		'training' => TrainingDataController::class,
		'testing' => TestingDataController::class,
		'atribut' => AtributController::class
	]);
	Route::prefix('class')->controller(ClassificationController::class)
		->name('class.')->group(function () {
			Route::get('/', 'index')->name('index')->block();
			Route::get('datatable', 'show')->name('datatable')->block();
			Route::post('calc', 'create')->name('create')->block();
			Route::delete('/', 'destroy')->name('reset')->block();
		});
	Route::get('result', [ResultController::class, 'index'])->name('result');
	Route::get('laravel', function () {
		return view('welcome');
	});
	Route::get('php', function () {
		return phpinfo();
	});
});

