<?php

namespace App\Providers;
use App\Models\NilaiAtribut;
use App\Models\TestingData;
use App\Models\TrainingData;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
	/**
	 * Register any application services.
	 */
	public function register(): void
	{
		//
	}

	/**
	 * Bootstrap any application services.
	 */
	public function boot(): void
	{
		TrainingData::resolveRelationUsing('nilai_atribut', function (TrainingData $training) {
			return $training->belongsTo(NilaiAtribut::class, 'id');
		});
		TestingData::resolveRelationUsing('nilai_atribut', function (TestingData $testing) {
			return $testing->belongsTo(NilaiAtribut::class, 'id');
		});
	}
}
