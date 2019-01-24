<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();
Route::get('/', 'PagesController@home');
Route::get('/attendance', 'PagesController@attendance');
Route::get('/contact', 'PagesController@contact');
Route::get('/about', 'PagesController@about');

Route::middleware(['auth'])->prefix('admin')->namespace('Admin')->group(function () {
    Route::get('/', 'DashboardController@index');
    Route::get('/dashboard', 'DashboardController@index');

    // faculties
    Route::get('/faculties', 'FacultyController@index');
    Route::post('/faculties', 'FacultyController@store');
    Route::put('/faculties/{id}', 'FacultyController@update');
    Route::delete('/faculties/{id}', 'FacultyController@destroy');

    // students
    Route::get('/students', 'StudentController@index');
    Route::get('/students/{id}', 'StudentController@show');
    Route::post('/students', 'StudentController@store');
    Route::put('/students/{id}', 'StudentController@update');
    Route::delete('/students/{id}', 'StudentController@destroy');
    Route::get('/students/{id}/attendance-statistics', 'StudentController@attendanceStatistics');

    // attendances
    Route::get('/attendances', 'AttendanceController@index');
    Route::put('/attendances/{id}', 'AttendanceController@update');

    // Statistics
    Route::get('/statistics', 'StatisticsController@index');
    Route::get('/statistics/faculty-present-percentages', 'StatisticsController@facultyPresentPercentages');
    Route::get('/statistics/top-students', 'StatisticsController@topStudents');


    // Datatables
    Route::get('/get-students', 'DatatableController@students');
    Route::get('/get-attendances', 'DatatableController@attendances');

});



