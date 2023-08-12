<?php

use Illuminate\Support\Facades\Route;
use Pterodactyl\Http\Middleware\AdminAuthenticate;

Route::middleware(['web', 'auth', 'csrf'])->prefix(config('billing.path'))->namespace('Billing')->group(function () {

  Route::group(['middleware' => [AdminAuthenticate::class]], function () {
    Route::get('/admin/overview', 'Admin\AdminCoreController@overview')->name('admin.billing');

    Route::get('/admin', 'Admin\AdminCoreController@index')->name('admin.billing.settings');
    Route::get('/admin/gateways', 'Admin\AdminCoreController@gateways')->name('admin.billing.gateways');
    
    Route::post('/admin/order', 'Admin\AdminCoreController@order')->name('admin.billing.order')->withoutMiddleware(['csrf']);
    Route::any('/admin/set/setiing', 'Admin\AdminCoreController@setSetting')->name('admin.billing.set.settings');
    
    Route::get('/admin/orders', 'Admin\AdminCoreController@orders')->name('admin.billing.orders');
    Route::get('/admin/order/{id}/manage', 'Admin\AdminCoreController@manageOrder')->name('admin.billing.order.manage');
    Route::get('/admin/order/{id}/delete', 'Admin\AdminCoreController@deleteOrder')->name('admin.billing.order.delete');
    Route::post('/admin/order/{id}/update', 'Admin\AdminCoreController@updateOrder')->name('admin.billing.order.update');
    Route::post('/admin/order/create', 'Admin\AdminCoreController@createOrder')->name('admin.billing.order.create');

    Route::get('/admin/tickets', 'Admin\AdminCoreController@tickets')->name('admin.tickets');
    Route::get('/admin/ticket/{id}', 'Admin\AdminCoreController@manageTicket')->name('admin.ticket.manage');

    Route::get('/admin/impersonate/{id}', 'Admin\AdminCoreController@impersonate')->name('admin.billing.impersonate');
    Route::get('/admin/force/schedular', 'Admin\AdminCoreController@forceSchedular')->name('admin.billing.schedular');

    Route::get('/admin/games', 'Admin\AdminCoreController@games')->name('admin.billing.games');
    Route::post('/admin/new/game', 'Admin\AdminCoreController@createGame')->name('admin.billing.create.game');
    Route::post('/admin/edit/game', 'Admin\AdminCoreController@editGame')->name('admin.billing.edit.game');
    Route::post('/admin/delete/game', 'Admin\AdminCoreController@deleteGame')->name('admin.billing.delete.game');

    Route::get('/admin/plans', 'Admin\AdminCoreController@plans')->name('admin.billing.plans');
    Route::post('/admin/new/plan', 'Admin\AdminCoreController@createPlan')->name('admin.billing.create.plan');
    Route::post('/admin/edit/plan', 'Admin\AdminCoreController@editPlan')->name('admin.billing.edit.plan');
    Route::post('/admin/delete/plan', 'Admin\AdminCoreController@deletePlan')->name('admin.billing.delete.plan');

    Route::get('/admin/users', 'Admin\AdminCoreController@users')->name('admin.billing.users');
    Route::get('/admin/user/{id}/invoices', 'Admin\AdminCoreController@userInvoices')->name('admin.billing.user.invoices');
    Route::get('/admin/user/{id}/payments', 'Admin\AdminCoreController@userPayments')->name('admin.billing.user.payments');
    Route::post('/admin/users/balance', 'Admin\AdminCoreController@newBalance')->name('admin.billing.users.balance');

    Route::get('/admin/emails', 'Admin\AdminCoreController@Emails')->name('admin.billing.emails');
    Route::post('/admin/emails/send', 'Admin\AdminCoreController@sendEmails')->name('admin.billing.emails.send');
    Route::get('/admin/email/{name}/{email}', 'Admin\AdminCoreController@userEmails')->name('admin.billing.user.email');
    Route::post('/admin/email/senduser', 'Admin\AdminCoreController@sendUserEmail')->name('admin.billing.user.email.post');

    Route::get('/admin/webhooks', 'Admin\AdminCoreController@Webhooks')->name('admin.billing.webhooks');
    Route::get('/admin/webhook/send', 'Admin\AdminCoreController@SendWebhook')->name('admin.billing.webhook.send');


    Route::get('/admin/pages', 'Admin\AdminCoreController@getPages')->name('admin.billing.pages');
    Route::get('/admin/pages/new', 'Admin\AdminCoreController@createPage')->name('admin.billing.pages.new');
    Route::get('/admin/pages/{id}/edit', 'Admin\AdminCoreController@updatePage')->name('admin.billing.pages.edit');
    Route::post('/admin/pages/save', 'Admin\AdminCoreController@savePage')->name('admin.billing.pages.save');
    Route::post('/admin/pages/delete', 'Admin\AdminCoreController@deletePage')->name('admin.billing.pages.delete');

    Route::get('/admin/discord', 'Admin\AdminCoreController@discord')->name('admin.discord');

    Route::get('/admin/alerts', 'Admin\AdminCoreController@alerts')->name('admin.billing.alerts');

    Route::get('/admin/portal', 'Admin\AdminCoreController@portal')->name('admin.billing.portal');
    Route::post('/admin/portal/faq', 'Admin\AdminCoreController@portalUpdate')->name('admin.billing.portal.update');

    Route::get('/admin/domain', 'Admin\AdminCoreController@domain')->name('admin.billing.domain');
    Route::post('/admin/domain/post', 'Admin\AdminCoreController@domainPOST')->name('admin.billing.domain.post');
    Route::get('/admin/domain/api', 'Admin\AdminCoreController@domainAPI')->name('admin.billing.domain.api');

    Route::get('/admin/meta', 'Admin\AdminCoreController@meta')->name('admin.billing.meta');

    Route::get('/admin/update', 'Admin\AdminCoreController@update')->name('admin.update');
    Route::get('/admin/update/install', 'Admin\AdminCoreController@updateInstall')->name('admin.update.install');

    Route::get('/admin/giftcard', 'Admin\AdminCoreController@giftcard')->name('admin.billing.giftcard');
    Route::post('/admin/giftcard/manage', 'Admin\AdminCoreController@giftcardManage')->name('admin.billing.giftcard.manage');
    Route::post('/admin/giftcard/mail', 'Admin\AdminCoreController@giftcardMail')->name('admin.billing.giftcard.mail');
  });

  // Billing Index Route -> /billing/
  Route::get('/', 'CoreController@index')->name('billing.link');

  // Billing Account Balance Route -> /billing/balance
  Route::any('/balance', 'ProfileController@index')->name('billing.balance');
  Route::any('/balance/update', 'ProfileController@updateUser')->name('billing.user.update');


  Route::post('/balance/stripe', 'ProfileController@stripe')->name('billing.balance.stripe');
  Route::post('/balance/giftcard', 'ProfileController@giftCard')->name('billing.balance.giftcard');

  // Billing Cart Route -> /billing/cart
  Route::get('/cart', 'CartController@index')->name('billing.cart');
  Route::get('/cart/order/all', 'CartController@orderAll')->name('billing.cart.order.all');
  Route::post('/add/cart', 'CartController@addToCart')->name('billing.add.cart');
  Route::post('/remove/cart', 'CartController@removeCart')->name('billing.remove.cart');

  // Billing Cart Route -> /billing/my-plans
  Route::get('/my-plans', 'MyPlansController@index')->name('billing.my-plans');
  Route::get('/my-plans/{id}', 'MyPlansController@plan')->name('billing.my-plans.plan');
  // Route::get('/my-plans/invoice/{id}', 'MyPlansController@view')->name('billing.my-plans.invoice.view');
  Route::get('/my-plans/{id}/update', 'MyPlansController@orderUpdate')->name('billing.my-plans.update');
  Route::get('/my-plans/{id}/upgrade', 'MyPlansController@upgrade')->name('billing.my-plans.upgrade');
  Route::get('/my-plans/{id}/cancel', 'MyPlansController@invoiceCancel')->name('billing.my-plans.cancel');
  Route::get('/my-plans/{id}/activate', 'MyPlansController@invoiceActivate')->name('billing.my-plans.activate');
  Route::post('/my-plans/subdomain/post', 'MyPlansController@setSubDomain')->name('billing.my-plans.subdomain');


  // Game Plans Route -> /billing/{game}/plans
  Route::get('/{game}/plans', 'PlansController@getPlans')->name('billing.plans');
  Route::get('/{game}/configure', 'PlansController@configure')->name('billing.plans.configure');

  // // Game Plans Route -> /billing/{game}/plans
  Route::get('/tickets', 'TicketsController@index')->name('tickets.index');
  Route::get('/tickets/new', 'TicketsController@newTicket')->name('tickets.new');
  Route::post('/tickets/new/create', 'TicketsController@newTicketCreate')->name('tickets.new.create');

  Route::get('/ticket/{uuid}', 'TicketsController@manage')->name('tickets.manage');
  Route::post('/ticket/{uuid}/new', 'TicketsController@addResponse')->name('tickets.manage.response');

  Route::get('/ticket/{uuid}', 'TicketsController@manage')->name('tickets.manage');
  Route::post('/ticket/{uuid}/new', 'TicketsController@addResponse')->name('tickets.manage.response');
  Route::get('/ticket/switch-status/{uuid}', 'TicketsController@statusSwitch')->name('tickets.switch');
  Route::get('/ticket/delete/{uuid}', 'TicketsController@delete')->name('tickets.delete');

});

Route::group(['middleware' => 'guest'], function () {
  Route::any('/billing/scheduler', 'Billing\CoreController@scheduler')->name('billing.scheduler');
});

Route::get('/billing/impersonate/{id}/{token}', 'Billing\CoreController@impersonate')->name('billing.impersonate');

Route::get('/toggle', 'Billing\CoreController@toggleMode')->name('billing.toggle.mode');
Route::get('/toggle/lang/{lang}', 'Billing\CoreController@toggleUserLang')->name('billing.toggle.lang');
