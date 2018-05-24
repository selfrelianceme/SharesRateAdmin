<?php

Route::group(['prefix' => config('adminamazing.path').'/sharesrateadmin', 'middleware' => ['web','CheckAccess']], function() {
	Route::get('/', 'Selfreliance\SharesRateAdmin\SharesRateAdminController@index')->name('AdminSharesRate');
	Route::get('/info', 'Selfreliance\SharesRateAdmin\SharesRateAdminController@rate_info')->name('AdminSharesRateInfoStore');
	Route::post('store', 'Selfreliance\SharesRateAdmin\SharesRateAdminController@store')->name('AdminSharesRateStore');
	Route::post('change_values', 'Selfreliance\SharesRateAdmin\SharesRateAdminController@change_values')->name('AdminSharesRateChangeRate');
	Route::get('delete/{id}', 'Selfreliance\SharesRateAdmin\SharesRateAdminController@destroy')->name('AdminSharesRateDelete');
	Route::get('percentage_growth/{id}', 'Selfreliance\SharesRateAdmin\SharesRateAdminController@percentage_growth')->name('AdminSharesRatePercentageGrowth');
});
