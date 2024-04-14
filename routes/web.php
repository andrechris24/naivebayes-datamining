<?php

use App\Exports\DatasetTemplate,
	App\Http\Controllers\AdminController,
	App\Http\Controllers\AtributController,
	App\Http\Controllers\ClassificationController,
	App\Http\Controllers\NilaiAtributController,
	App\Http\Controllers\ProbabilityController,
	App\Http\Controllers\ResultController,
	App\Http\Controllers\TestingDataController,
	App\Http\Controllers\TrainingDataController,
	App\Livewire\Auth\Forgot,
	App\Livewire\Auth\Login,
	App\Livewire\Auth\Register,
	App\Livewire\Auth\Reset,
	// App\Livewire\Logout,
	// App\Livewire\Performance,
	// App\Livewire\Probab,
	// App\Livewire\Profile,
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
Route::middleware(['guest'])->group(function(){
	Route::get('register',Register::class)->name('register');
	Route::get('login', Login::class)->name('login');
	Route::prefix('password')->name('password.')->group(function(){
		Route::get('/',Forgot::class)->name('forget');
		Route::get('reset', Reset::class)->name('reset');
	});
});
Route::middleware(['auth'])->group(function () {
	// Route::get('profile',Profile::class)->name('profil');
	Route::get('/', [AdminController::class,'index'])->name('home');
	Route::controller(AdminController::class)->group(function () {
		Route::prefix('profile')->name('profil.')->group(function () {
			Route::get('/', 'edit')->name('edit');
			Route::middleware(['throttle:user'])->group(function () {
				Route::patch('/', 'update')->name('update');
				Route::delete('/', 'delete')->name('delete');
			});
		});
		Route::post('logout','logout')->name('logout');
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
	// Route::get('probab',Probab::class)->name('probab');
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
			Route::get('export', 'export')->name('export')->block();
			Route::post('calc', 'create')->name('create')->block();
			Route::delete('/', 'destroy')->name('reset')->block();
		});
	Route::get('result', ResultController::class)->name('result');
	Route::get('template', function () {
		return (new DatasetTemplate)->download('template.xlsx');
	})->name('template-data');
	Route::get('laravel', function () {
		return view('welcome');
	})->name('laravel');
	Route::get('php', function () {
		return phpinfo();
	})->name('phpinfo');
});
