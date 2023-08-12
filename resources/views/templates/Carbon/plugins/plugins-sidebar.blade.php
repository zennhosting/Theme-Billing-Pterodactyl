<div class="l-navbar" id="nav-bar" style="z-index: 40;">
  <nav class="nav" style="height: 100%">
    <div style="height: 100%">
      <a class="logo-expand site-logo" href="/">
        <img onclick="window.location.href='/'" src="@if(isset($settings['logo'])){{ $settings['logo'] }}@else /assets/svgs/pterodactyl.svg @endif" style="width: 42px; padding: 4px;">{{ config('app.name', 'Pterodactyl') }}</a>

      <div class="nav_list" style="overflow: auto; height: 90%;">
        <div class="dropdown-divider"></div>
        @if(config('billing.portal') == "true") <a href="{{ route('billing.portal') }}" class="nav_link" id="sbBilling"><i class='bx bxs-dashboard nav_icon sidebar-card'></i> <span class="nav_name">{!! Bill::lang()->get('portal') !!}</span> </a>@endif
        <a href="{{ route('billing.link') }}" class="nav_link @if($active_nav == 'billing') sb-active @endif" id="sbBilling"><i class='bx bxs-package nav_icon sidebar-card'></i> <span class="nav_name">{!! Bill::lang()->get('billing_page') !!}</span> </a>
        <a href="{{ route('billing.balance') }}" class="nav_link @if($active_nav == 'balance') sb-active @endif" id="sbBalance"><i class='bx bx-wallet nav_icon sidebar-card'></i> <span class="nav_name">{!! Bill::lang()->get('balance_page') !!}</span> </a>
        <a href="{{ route('billing.cart') }}" class="nav_link @if($active_nav == 'cart') sb-active @endif" id="sbCart"><i class='bx bx-basket nav_icon sidebar-card'></i> <span class="nav_name">{!! Bill::lang()->get('cart_page') !!}</span> </a>
        <a href="{{ route('billing.my-plans') }}" class="nav_link @if($active_nav == 'invoices') sb-active @endif" id="sbInvoices"><i class='bx bx-receipt nav_icon sidebar-card'></i> <span class="nav_name">{!! Bill::lang()->get('plan_page') !!}</span> </a>
        <a href="/" class="nav_link"> <i class='bx bx-server nav_icon sidebar-card'></i> <span class="nav_name">{!! Bill::lang()->get('servers_page') !!}</span> </a>

        @if(count(Bill::settings()->getCustomPages()))
        <div class="dropdown-divider"></div>
        @foreach(Bill::settings()->getCustomPages() as $key => $page)

        @if(isset($page->type) and $page->type == 1)
        <a href="{{ $page->url }}" target="_blank" class="nav_link" id="sbBillingPage{{ $page->id }}"><i class="{{ $page->icon }} nav_icon sidebar-card "></i> <span class="nav_name">{{ $page->custom }}</span> </a>
        @else
        <a href="{{ route('billing.custom.page', ['page' => $page->url]) }}" class="nav_link @if($active_nav == $page->url) sb-active @endif" id="sbBillingPage{{ $page->id }}"><i class="{{ $page->icon }} nav_icon sidebar-card "></i> <span class="nav_name">@if(isset($page->custom)){{ $page->custom }} @else {{ ucfirst($page->url) }} @endif</span> </a>
        @endif

        @endforeach
        @endif

        <div class="dropdown-divider"></div>
        <a href="/server/{{ $server }}" class="nav_link"> <i class='bx bx-terminal nav_icon sidebar-card'></i> <span class="nav_name">{!! Bill::lang()->get('console_page') !!}</span> </a>
        <a href="/server/{{ $server }}/files" class="nav_link"> <i class='bx bx-folder nav_icon sidebar-card'></i> <span class="nav_name">{!! Bill::lang()->get('files_page') !!}</span> </a>

        <a href="{{ route('plugins.server_core', $server) }}" class="nav_link @if(Route::currentRouteName() == 'plugins.server_core') sb-active @endif" id="sbVersion"> <i class='bx bx-chevrons-down nav_icon sidebar-card'></i> <span class="nav_name">{!! Bill::lang()->get('version_page') !!}</span> </a>

        @if(Bill::isPluginPerms($server))
        <a href="{{ route('plugin', $server) }}" class="nav_link @if(Route::currentRouteName() == 'plugin' or Route::currentRouteName() == 'plugins' or Route::currentRouteName() == 'plugins.installed') sb-active @endif" id="sbPlugins"> <i class='bx bx-plug nav_icon sidebar-card'></i> <span class="nav_name">{!! Bill::lang()->get('plugin_page') !!}</span> </a>
        @endif

        <a href="/server/{{ $server }}/databases" class="nav_link"> <i class='bx bx-data nav_icon sidebar-card'></i> <span class="nav_name">{!! Bill::lang()->get('databases_page') !!}</span> </a>
        <a href="/server/{{ $server }}/schedules" class="nav_link"> <i class='bx bx-time-five nav_icon sidebar-card'></i> <span class="nav_name">{!! Bill::lang()->get('shedulers_page') !!}</span> </a>
        <a href="/server/{{ $server }}/users" class="nav_link"> <i class='bx bx-user nav_icon sidebar-card nav_icon sidebar-card'></i> <span class="nav_name">{!! Bill::lang()->get('users_page') !!}</span> </a>
        <a href="/server/{{ $server }}/backups" class="nav_link"> <i class='bx bx-cloud-download nav_icon sidebar-card'></i> <span class="nav_name">{!! Bill::lang()->get('backups_page') !!}</span> </a>
        <a href="/server/{{ $server }}/network" class="nav_link"> <i class='bx bx-network-chart nav_icon sidebar-card'></i> <span class="nav_name">{!! Bill::lang()->get('network_page') !!}</span> </a>
        <a href="/server/{{ $server }}/startup" class="nav_link"> <i class='bx bx-slider nav_icon sidebar-card'></i> <span class="nav_name">{!! Bill::lang()->get('startup_page') !!}</span> </a>
        <a href="/server/{{ $server }}/settings" class="nav_link"> <i class='bx bx-briefcase-alt-2 nav_icon sidebar-card'></i> <span class="nav_name">{!! Bill::lang()->get('settings_page') !!}</span> </a>
        @if(Auth::user()->root_admin)
        <a onClick="openManage()" class="nav_link" id="sbManage" style="display: none;"> <i class='bx bx-wrench nav_icon sidebar-card'></i> <span class="nav_name">{!! Bill::lang()->get('manage_page') !!}</span> </a>
        @endif

        <a href="/account" class="nav_link"> <i class='bx bx-user nav_icon sidebar-card'></i> <span class="nav_name">{!! Bill::lang()->get('account_page') !!}</span> </a>
        @if(Auth::user()->root_admin)
        <a href="{{ route('admin.billing') }}" class="nav_link"> <i class='bx bx-key nav_icon sidebar-card'></i> <span class="nav_name">{!! Bill::lang()->get('admin_page') !!}</span> </a>
        @endif
        <a href="{{ route('auth.logout') }}" class="nav_link"> <i class='bx bx-power-off nav_icon sidebar-card'></i> <span class="nav_name">{!! Bill::lang()->get('out_page') !!}</span> </a>
      </div>
    </div>
  </nav>
</div>

<!--Container Main start-->

<button type="button" style="display: none;background-color: var(--first-color);width: 100%; margin-bottom: 10px; border-color: transparent; text-transform: uppercase;top: 7px;" id="output-server-status" class="btn btn-primary btn-lg btn-block">{!! Bill::lang()->get('connecting') !!}</button>


</section>
</div>

@include('templates.Carbon.inc.alerts')

@if ($errors->any())
<div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin-top: @isset($settings['alerts_status'])@if( $settings['alerts_status'] == " true") 20px; @else 80px; @endif @endisset">
  <span class="alert-inner--icon"><i class='bx bx-x'></i></span>
  <span class="alert-inner--text"><strong>{!! Bill::lang()->get('error') !!}</strong> @foreach ($errors->all() as $error){{ $error }}@endforeach</span>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
@endif


@if(session()->has('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-top: @isset($settings['alerts_status'])@if( $settings['alerts_status'] == " true") 20px; @else 80px; @endif @endisset">
  <span class="alert-inner--icon"><i class='bx bx-check'></i></span>
  <span class="alert-inner--text"><strong>{!! Bill::lang()->get('success') !!}</strong> {{ session()->get('success') }}</span>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
@endif
