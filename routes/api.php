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
    Route::get('load_edocs', 'loadEdocs')->name('load_edocs');
    Route::get('load_approver_by_doc_id', 'loadApproverByDocId')->name('load_approver_by_doc_id');
    Route::get('read_document_by_id', 'readDocumentById')->name('read_document_by_id');
    Route::get('read_approver_name_by_id', 'readApproverNameById')->name('read_approver_name_by_id');
    Route::get('read_approver_name', 'readApproverName')->name('read_approver_name');
    // Route::get('update_edocs_approval_status', 'updateEdocsApprovalStatus')->name('update_edocs_approval_status');

    Route::get('convert_pdf_to_image_by_page_number', 'convertPdfToImageByPageNumber')->name('convert_pdf_to_image_by_page_number');
    Route::get('pdf/view', 'showPdfWithSignatures')->name('/pdf/view');
    Route::get('get_document_Info_for_email', 'getDocumentInfoForEmail')->name('get_document_Info_for_email');
    Route::get('encrypt_decrypt_variable', 'encryptDecryptVariable')->name('encrypt_decrypt_variable');

    Route::post('save_document', 'saveDocument')->name('save_document');
    Route::post('update_edocs_approval_status', 'updateEdocsApprovalStatus')->name('update_edocs_approval_status');
});

Route::controller(SettingsController::class)->group(function () {
    Route::get('get_user_master', 'getUserMaster')->name('get_user_master');
});
