<?php

use App\Exports\DatasetTemplate,
	App\Http\Controllers\AdminController,
	App\Http\Controllers\AtributController,
	App\Http\Controllers\AuthController,
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

Route::middleware(['guest'])->controller(AuthController::class)->group(function () {
	Route::prefix('register')->name('register')->group(function () {
		Route::get('/', 'register');
		Route::post('/', 'postRegister')->name('.submit');
	});
	Route::prefix('login')->name('login')->group(function () {
		Route::get('/', 'login');
		Route::post('/', 'postLogin')->name('.submit');
	});
	Route::prefix('password')->name('password.')->group(function () {
		Route::get('/', 'forget')->name('forget');
		Route::post('/', 'forgetLink')->name('send');
		Route::prefix('reset')->group(function () {
			Route::get('/', 'showReset')->name('change');
			Route::patch('/', 'reset')->name('reset');
		});
	});
});
Route::middleware(['auth'])->group(function () {
	Route::controller(AdminController::class)->group(function () {
		Route::get('/', 'index')->name('home');
		Route::prefix('profil')->name('profil.')->group(function () {
			Route::get('/', 'edit')->name('index');
			Route::post('/', 'update')->name('update');
			Route::delete('/', 'delete')->name('delete');
		});
		Route::post('logout', 'logout')->name('logout');
	});
	Route::controller(TrainingDataController::class)->prefix('training')
		->name('training.')->group(function () {
			Route::get('count', 'count')->name('count')->block();
			Route::get('download', 'export')->name('export')->block();
			Route::post('upload', 'import')->name('import')->block();
			Route::delete('/', 'clear')->name('clear')->block();
		});
	Route::controller(TestingDataController::class)->prefix('testing')
		->name('testing.')->group(function () {
			Route::get('count', 'count')->name('count')->block();
			Route::get('download', 'export')->name('export')->block();
			Route::post('upload', 'import')->name('import')->block();
			Route::delete('/', 'clear')->name('clear')->block();
		});
	Route::controller(ProbabilityController::class)->prefix('probab')
		->name('probab.')->group(function () {
			Route::get('/', 'index')->name('index');
			Route::get('calc', 'create')->name('create');
			Route::delete('/', 'destroy')->name('reset');
		});
	Route::prefix('atribut')->name('atribut.')->group(function () {
		Route::get('count', [AtributController::class, 'count'])->name('count')
			->block();
		Route::get('nilai/count', [NilaiAtributController::class, 'count'])
			->name('nilai.count')->block();
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
			Route::get('export/{type}', 'export')->name('export')->block();
			Route::post('calc', 'create')->name('create')->block();
			Route::delete('/', 'destroy')->name('reset')->block();
		});
	Route::get('result', ResultController::class)->name('result');
	Route::get('template', function () {
		return (new DatasetTemplate)->download('template_' . time() . '.xlsx');
	})->name('template-data');
	Route::get('laravel', function () {
		return view('welcome');
	})->name('laravel');
	Route::get('php', function () {
		return phpinfo();
	})->name('phpinfo');
});
Route::get('test-area', function () {
	echo -50 / 80 * log(50 / 80, 2) + (-30 / 80) * log(30 / 80, 2);
})->name('test-route');
