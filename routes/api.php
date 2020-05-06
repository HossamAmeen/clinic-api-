<?php

use Illuminate\Http\Request;

Route::namespace ("APIs")->group(function () {
    Route::prefix("client")->group(function () {
        Route::post("login", "ClientController@login");
        Route::get("account", "ClientController@getAccount");
        Route::put("update", "ClientController@updateAccount");
        Route::put("update/password", "ClientController@updatePassword");
        Route::get("licence", "ClientController@getLastLicence");
        Route::get("patients", "ClientController@getPatients");
        Route::get("patient/{id}", "ClientController@getPatient");
        Route::get("patient/visits/{id}", "ClientController@getPatientVisits");
        Route::get("visits/{id}", "ClientController@getPatientVisit");
        Route::get("appointments/{id?}", "ClientController@getAppointments");
        Route::post("appointment", "ClientController@setAppointment");
        Route::put("delay-appointment", "ClientController@delayAppointment");
        Route::get("change-order-appointment", "ClientController@change_order_appointment");
        Route::put("reset-password", "ClientController@resetPasswotd");
        Route::post("send-token", "ClientController@sendToken");
    });

    Route::get("countries", "MobileController@countries");
    Route::get("cities", "MobileController@cities");
    Route::get("towns", "MobileController@towns");
    Route::get("visit-types/{id}", "MobileController@visit_types");
    Route::get("speciallists", "MobileController@specials");
    Route::get("external-links", "MobileController@externalLinks");
    Route::post("contact", "MobileController@contact");
    Route::get("prefs", "MobileController@pref");



    Route::middleware('auth:client-api')->group(function () {
        Route::post("order", "ClientController@addOrder");
        Route::post("rate-order/{id}", "ClientController@addRate");
        Route::get("client/orders", "ClientController@showOrders");
        Route::put("account/update", "ClientController@updateAccount");
    });
    Route::post("rate-order-test/{id}", "ClientController@addRate");
});
