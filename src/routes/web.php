<?php

use Illuminate\Support\Facades\Route;
use  Xoxoday\Fileupload\Http\Controller\FileUploadController;

Route::group(['middleware' => ['web']], function () {

Route::post('/fileUpload', [FileUploadController::class, 'uploadFile']);

Route::post('/verifyOtp', [FileUploadController::class, 'verifyOtp']);

});
