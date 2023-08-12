<?php

use Pterodactyl\Http\Middleware\GMD;
use Pterodactyl\Http\Middleware\AdminAuthenticate;

Route::middleware(['web', GMD::class])->group(function () {

  foreach (File::allFiles(__DIR__ . '/custom') as $route_file) {
    require_once $route_file->getPathname();
  }

  Route::middleware([AdminAuthenticate::class])->group(function () {
    Route::get('/admin/gmd', 'GMD\GMDController@admin')->name('admin.gmd');
  });
});
