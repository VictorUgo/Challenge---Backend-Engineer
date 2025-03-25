<?php

use App\Http\Controllers\Api\CompanyController;
use Illuminate\Support\Facades\Route;



Route::get('/companies', [CompanyController::class, 'index']);  // Nueva ruta para listar
Route::post('/companies', [CompanyController::class, 'store']);
Route::put('/companies/{id}/agent', [CompanyController::class, 'updateAgent']);
Route::get('/agents/capacity/{state}', [CompanyController::class, 'checkCapacity']);
Route::get('/companies/{id}', [CompanyController::class, 'show']);
