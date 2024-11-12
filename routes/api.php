<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EdocsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::controller(EdocsController::class)->group(function () {
    Route::get('get_module', 'get_module')->name('get_module');
    Route::post('save_document', 'saveDocument')->name('save_document');
    Route::get('read_document_by_id', 'readDocumentById')->name('read_document_by_id');
    Route::get('convert_pdf_to_image_by_page_number', 'convertPdfToImageByPageNumber')->name('convert_pdf_to_image_by_page_number');
    Route::get('/pdf/view', 'showPdf')->name('/pdf/view');
});
