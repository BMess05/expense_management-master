<?php 
 Route::group(['middleware' => ['auth','CheckMaintenanceStatus'] ], function() {

    Route::group(['prefix'=>'resume/resumes'], function() {
        Route::get('/', 'App\Http\Controllers\Resume\ResumeController@index')->name('resumes');
        
        Route::get('/add', 'App\Http\Controllers\Resume\ResumeController@add')->name('addResume');
        Route::post('/save', 'App\Http\Controllers\Resume\ResumeController@save')->name('saveResume');
    
        Route::get('/edit/{id}', 'App\Http\Controllers\Resume\ResumeController@edit')->name('editResume');
        Route::post('/update/{id}', 'App\Http\Controllers\Resume\ResumeController@update')->name('updateResume');
        Route::get('/delete/{id}/{type?}', 'App\Http\Controllers\Resume\ResumeController@delete')->name('deleteResume');
        Route::get('/download/{id}', 'App\Http\Controllers\Resume\ResumeController@download')->name('downloadResume');
        Route::post('/archive', 'App\Http\Controllers\Resume\ResumeController@archive')->name('archiveResume');
       
    });

    Route::group(['prefix'=>'resume/category'], function() {
        Route::get('/', 'App\Http\Controllers\Resume\ResumeCategoryController@index')->name('resumeCategory');
        
        Route::get('/add', 'App\Http\Controllers\Resume\ResumeCategoryController@add')->name('addResumeCategory');
        Route::post('/save', 'App\Http\Controllers\Resume\ResumeCategoryController@save')->name('saveResumeCategory');
    
        Route::get('/edit/{id}', 'App\Http\Controllers\Resume\ResumeCategoryController@edit')->name('editResumeCategory');
        Route::post('/update/{id}', 'App\Http\Controllers\Resume\ResumeCategoryController@update')->name('updateResumeCategory');
        Route::get('/delete/{id}/{type?}', 'App\Http\Controllers\Resume\ResumeCategoryController@delete')->name('deleteResumeCategory');
       
    });




   });

