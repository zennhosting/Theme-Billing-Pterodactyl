<?php

Route::any('/toggle-mode', 'GMD\GMDController@toggleMode')->name('toggle_mode');
Route::post('/set-template', 'GMD\GMDController@setTemplate')->name('set_template');
