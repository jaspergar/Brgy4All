<?php

use App\Http\Middleware\AdminCheck;
use Illuminate\Support\Facades\Route;

Route::prefix('/app')->middleware(AdminCheck::class)->group(function () {

    //Authentication 
    Route::post('/admin_login', 'AuthenticationController@adminLogin');

    //------------CITIZEN---------------
    Route::get('/get_citizen', 'AdminController@getCitizen');
    // -----------ADMIN--------------
    //SERVICE
    Route::post('/upload_file', 'AdminController@uploadFileToServer');
    Route::post('/delete_file', 'AdminController@deleteFileFromServer');
    Route::post('/create_service', 'AdminController@addServiceToDb');
    Route::get('/getall_services', 'AdminController@getAllServicesFromDb');
    Route::delete('/delete_service', 'AdminController@deleteServiceFromDb');
    Route::put('/edit_service', 'AdminController@editServiceFromDb');
    Route::post('/generate_attendance', 'AdminController@generateAttendance');
    Route::post('/get_sectorsById', 'AdminController@getSectorsById');
    Route::post('/create_attendance', 'AdminController@createAttendance');
    Route::post('/countAllNumOfAttendance', 'AdminController@countAllNumOfCitAttendance');
    Route::post('/getFullServiceDetails/{id}', 'AdminController@getFullServiceDetails');
    Route::post('/getServiceAttendanceList/{id}', 'AdminController@getServiceAttendanceList');

    //ANNOUNCEMENT
    Route::post('/create_announcement', 'AdminController@addAnnouncementToDb');
    Route::get('/getall_announcements', 'AdminController@getAllAnnouncementFromDb');
    Route::put('/edit_announcement', 'AdminController@editAnnouncementFromDb');
    Route::delete('/delete_announcement', 'AdminController@deleteAnnouncementFromDb');

    //CITIZEN
    Route::get('/getall_citizen', 'AdminController@getAllCitizen');
    Route::put('/update_status', 'AdminController@updataStatus');

    //Worker
    Route::post('/create_worker', 'AdminController@addWorkerToDb');
    Route::get('/getall_workers', 'AdminController@getAllWorkerFromDb');
    Route::put('/edit_worker', 'AdminController@editWorkerFromDb');
    Route::delete('/delete_worker', 'AdminController@deleteWorkerFromDb');
});

// ---------ADMIN --------------

Route::get('/logout', 'AuthenticationController@logout');
Route::get('/', 'AuthenticationController@index');
Route::any('{slug}', 'AuthenticationController@index');
// Route::get('/', function () {
//     return view('welcome');
// });

// Route::any('{slug}',  function () {
//     return view('welcome');
// });
