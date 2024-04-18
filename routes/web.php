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
	// App\Livewire\Attrib,
	// App\Livewire\Classify,
	// App\Livewire\Dashboard,
	// App\Livewire\DataTemplate,
	// App\Livewire\DataTesting,
	// App\Livewire\DataTraining,
	// App\Livewire\Logout,
	// App\Livewire\Performance,
	// App\Livewire\Probab,
	// App\Livewire\Profile,
	// App\Livewire\SubAttribute,
	// App\Http\Controllers\DataTableController,
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

Route::middleware(['guest'])->group(function () {
	Route::get('register', Register::class)->name('register');
	Route::get('login', Login::class)->name('login');
	Route::prefix('password')->name('password.')->group(function () {
		Route::get('/', Forgot::class)->name('forget');
		Route::get('reset', Reset::class)->name('reset');
	});
});
Route::middleware(['auth'])->group(function () {
	// ========================== Non-Livewire Routing ==========================
	Route::controller(AdminController::class)->group(function () {
		Route::get('/', 'index')->name('home');
		Route::prefix('profil')->name('profil.')->group(function () {
			Route::get('/', 'edit')->name('index');
			Route::middleware(['throttle:user'])->group(function () {
				Route::post('/', 'update')->name('update');
				Route::delete('/', 'delete')->name('delete');
			});
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
		return (new DatasetTemplate)->download('template.xlsx');
	})->name('template-data');

	// ============================ Livewire Routing ============================
	// Livewire hanya digunakan pada Guest Middleware saja
	// karena banyak bug yang sulit untuk diperbaiki

	// Route::get('/', Dashboard::class)->name('home');
	// Route::get('profil', Profile::class)->name('profil');
	// Route::prefix('atribut')->name('atribut')->group(function(){
	// 	Route::get('/', Attrib::class)->block();
	// 	Route::get('count', [DataTableController::class,'countattr'])
	// 	->name('.count')->block();
	// 	Route::get('dt',[DataTableController::class,'atribut'])->name('.dt')
	// 	->block();
	// 	Route::prefix('nilai')->name('.nilai')->group(function(){
	// 		Route::get('/',SubAttribute::class)->block();
	// 		Route::get('count',[DataTableController::class,'countsubattr'])
	// 		->name('.count')->block();
	// 		Route::get('dt',[DataTableController::class,'nilaiatribut'])->name('.dt')
	// 		->block();
	// 	});
	// });
	// Route::prefix('training')->name('training')->group(function(){
	// 	Route::get('/',DataTraining::class)->block();
	// 	Route::get('count',[DataTableController::class,'counttrain'])
	// 	->name('.count')->block();
	// 	Route::get('dt',[DataTableController::class,'trainingdata'])->name('.dt')
	// 	->block();
	// });
	// Route::prefix('testing')->name('testing')->group(function(){
	// 	Route::get('/',DataTesting::class)->block();
	// 	Route::get('count',[DataTableController::class,'counttest'])
	// 	->name('.count')->block();
	// 	Route::get('dt',[DataTableController::class,'testingdata'])->name('.dt')
	// 	->block();
	// });
	// Route::get('probab', Probab::class)->name('probab');
	// Route::prefix('class')->name('class')->group(function(){
	// 	Route::get('/',Classify::class)->block();
	// 	Route::get('dt', [DataTableController::class,'klasifikasi'])->name('.dt')
	// 	->block();
	// });
	// Route::get('result', Performance::class)->name('result');
	// Route::post('logout',Logout::class)->name('logout');

	Route::get('laravel', function () {
		return view('welcome');
	})->name('laravel');
	Route::get('php', function () {
		return phpinfo();
	})->name('phpinfo');
});
