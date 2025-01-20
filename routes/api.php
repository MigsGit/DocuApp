<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EdocsController;
use App\Http\Controllers\SettingsController;

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
    Route::get('read_document_by_id', 'readDocumentById')->name('read_document_by_id');
    Route::get('read_approver_name_by_id', 'readApproverNameById')->name('read_approver_name_by_id');
    Route::get('read_approver_name', 'readApproverName')->name('read_approver_name');
    Route::get('convert_pdf_to_image_by_page_number', 'convertPdfToImageByPageNumber')->name('convert_pdf_to_image_by_page_number');
    Route::get('/pdf/view', 'showPdf')->name('/pdf/view');

    Route::post('save_document', 'saveDocument')->name('save_document');
});

Route::controller(SettingsController::class)->group(function () {
    Route::get('get_user_master', 'getUserMaster')->name('get_user_master');
});
