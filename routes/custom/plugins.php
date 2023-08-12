<?php

use Pterodactyl\Http\Middleware\RequireTwoFactorAuthentication;
use Illuminate\Support\Facades\Route;

Route::get('/server/{server}/plugins', 'Plugins\PluginsController@index')
  ->withoutMiddleware(RequireTwoFactorAuthentication::class)
  ->name('plugin');

Route::get('/server/{server}/plugins/{p}', 'Plugins\PluginsController@index')
  ->withoutMiddleware(RequireTwoFactorAuthentication::class)
  ->name('plugins');

Route::get('/server/{server}/plugins/category/{id}/{p}', 'Plugins\PluginsController@category')
  ->withoutMiddleware(RequireTwoFactorAuthentication::class)
  ->name('plugins.category');


Route::get('/server/{server}/plugins/search/{find}/{p}', 'Plugins\PluginsController@search')
  ->withoutMiddleware(RequireTwoFactorAuthentication::class)
  ->name('plugins.search');

Route::get('/server/{server}/plugins/upload/{pl_id}/{pl_name}', 'Plugins\PluginsController@upload')
  ->withoutMiddleware(RequireTwoFactorAuthentication::class)
  ->name('plugins.upload');

Route::get('/server/{server}/pluginsurl/get', 'Plugins\PluginsController@getUpURL')
  ->withoutMiddleware(RequireTwoFactorAuthentication::class)
  ->name('plugins.getupurl');

Route::get('/plugin/isminectaft/{server?}', 'Plugins\PluginsController@isMinecraft')
->withoutMiddleware(RequireTwoFactorAuthentication::class)
->name('plugins.isminecraft');

Route::get('/server/{server}/pl-installed', 'Plugins\PluginsController@installed')
->withoutMiddleware(RequireTwoFactorAuthentication::class)
->name('plugins.installed');

Route::get('/server/{server}/pl-autoupdate/{pl_id}', 'Plugins\PluginsController@plAutoupdate')
->withoutMiddleware(RequireTwoFactorAuthentication::class)
->name('plugins.autoupdate');

Route::get('/server/{server}/pl-remove/{pl_id}', 'Plugins\PluginsController@plRemove')
->withoutMiddleware(RequireTwoFactorAuthentication::class)
->name('plugins.remove');

Route::get('/pl-scheduler', 'Plugins\PluginsController@scheduler')
->withoutMiddleware(RequireTwoFactorAuthentication::class)
->name('plugins.scheduler');

Route::get('/server/{server}/version', 'Plugins\PluginsController@core')
->withoutMiddleware(RequireTwoFactorAuthentication::class)
->name('plugins.server_core');

Route::post('/server/{server}/set/core', 'Plugins\PluginsController@setCore')
->withoutMiddleware(RequireTwoFactorAuthentication::class)
->name('plugins.set_core');

Route::get('/server/{server}/rem/core', 'Plugins\PluginsController@removeCore')
->withoutMiddleware(RequireTwoFactorAuthentication::class)
->name('plugins.remove_core');