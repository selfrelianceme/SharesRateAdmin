<?php

Route::group(['prefix' => config('adminamazing.path').'/sharesrateadmin', 'middleware' => ['web','CheckAccess']], function() {
	Route::get('/', 'Selfreliance\SharesRateAdmin\SharesRateAdminController@index')->name('AdminSharesRate');
	Route::post('store', 'Selfreliance\SharesRateAdmin\SharesRateAdminController@store')->name('AdminSharesRateStore');
});
