<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::resource('subscription-plans', 'Api\V1\SubscriptionPlanController');

    Route::resource('lessons', 'Api\V1\LessonController');
    Route::get('lessons/{language_id}/{module}', 'Api\V1\LessonController@show');

    Route::get('module-exercises/{token}', 'Api\V1\ModuleExerciseController@show');

    Route::get('paypal/plans', 'Api\V1\PaypalController@showPlans');
    Route::get('paypal/plan/{planId}', 'Api\V1\PaypalController@showSubscription');
    Route::get('paypal/subscription/{subscriptionId}/{userToken}', 'Api\V1\PaypalController@getSubscription');

    Route::get('lesson-progress/{user_id}', 'Api\V1\LessonProgressController@index');
    Route::get('lesson-progress-show/{user_id}/{lesson_id}', 'Api\V1\LessonProgressController@show');
    Route::post('lesson-progress-store', 'Api\V1\LessonProgressController@store');
    Route::put('lesson-progress-update', 'Api\V1\LessonProgressController@update');

    Route::post('assistant/improve', 'Api\V1\AssistantController@improve')->name('assistant.improve');
    Route::post('assistant/explain', 'Api\V1\AssistantController@explain')->name('assistant.explain');
});
