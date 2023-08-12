@include('templates.Carbon.billing.admin.notice')
@section('billing::nav')
    @yield('billing::notice')
    <style>.fa, .fas{padding-left:3px;}</style>
    <div class="row">
        <div class="col-xs-12">
            <div class="nav-tabs-custom nav-tabs-floating">
                <ul class="nav nav-tabs">
                    <li @if($activeTab === 'overview')class="active"@endif><a href="{{ route('admin.billing') }}"><i class="fas fa-solid fa-layer-group"></i> Overview</a></li>
                    <li @if($activeTab === 'basic')class="active"@endif><a href="{{ route('admin.billing.settings') }}"><i class="fas fa-cog"></i> Settings</a></li>
                    <li @if($activeTab === 'orders')class="active"@endif><a href="{{ route('admin.billing.orders') }}"><i class="fas fa-solid fa-server"></i> Orders</a></li>
                    <li @if($activeTab === 'games')class="active"@endif><a href="{{ route('admin.billing.games') }}"><i class="fas fa-cube"></i> Games</a></li>
                    <li @if($activeTab === 'plans')class="active"@endif><a href="{{ route('admin.billing.plans') }}"><i class="fas fa-cubes"></i> Plans</a></li>
                    <li @if($activeTab === 'users')class="active"@endif><a href="{{ route('admin.billing.users') }}"><i class="fas fa-users"></i> Users</a></li>
                    <li @if($activeTab==='affiliates' )class="active" @endif><a href="{{ route('admin.billing.affiliates') }}"><i class="fa fa-money"></i> Affiliates</a></li>
                    <li @if($activeTab === 'pages')class="active"@endif><a href="{{ route('admin.billing.pages') }}"><i class="fas fa-list"></i> Pages</a></li>
                    <li @if($activeTab === 'discord')class="active"@endif><a href="{{ route('admin.discord') }}"><i class="fab fa-discord"></i> Discord</a></li>
                    <li @if($activeTab === 'alerts')class="active"@endif><a href="{{ route('admin.billing.alerts') }}"><i class="fas fa-exclamation-triangle"></i> Alerts</a></li>
                    <li @if($activeTab === 'portal')class="active"@endif><a href="{{ route('admin.billing.portal') }}"><i class="fas fa-images"></i> Portal</a></li>
                    <li @if($activeTab === 'domain')class="active"@endif><a href="{{ route('admin.billing.domain') }}"><i class="fas fa-solid fa-sitemap"></i> Domain</a></li>
                    <li @if($activeTab === 'emails')class="active"@endif><a href="{{ route('admin.billing.emails') }}"><i class="fas fa-solid fa-at"></i> Emails</a></li>
                    <li @if($activeTab === 'meta')class="active"@endif><a href="{{ route('admin.billing.meta') }}"><i class="fas fa-link"></i> Meta</a></li>
                    <li @if($activeTab === 'giftcard')class="active"@endif><a href="{{ route('admin.billing.giftcard') }}"><i class="fas fa-gift"></i> GiftCard</a></li>
                    <li @if($activeTab==='gateways' )class="active" @endif><a href="{{ route('admin.billing.gateways') }}"><i class="fa fa-paypal"></i> Gateways</a></li>
                    <li @if($activeTab === 'update')class="active"@endif><a href="{{ route('admin.update') }}"><i class="fas fa-cloud-download-alt"></i> Update</a></li>
                </ul>
            </div>
        </div>
    </div>

    @if(session()->has('error'))
    <div class="alert alert-danger" style="display: flex;align-items: center;">
    <span class="badge badge-pill badge-success" style="background: #981b1b;margin-right: 10px;">Error</span> 
        {{ session()->get('error') }}
    </div>
    @endif

    @if(session()->has('success'))
    <div class="alert alert-success" style="display: flex;align-items: center;">
        <span class="badge badge-pill badge-success" style="background: green;margin-right: 10px;">Success</span> 
        {{ session()->get('success') }}
    </div>
    @endif

    @if(session()->has('warning'))
    <div class="alert alert-warning" style="display: flex;align-items: center;">
        <span class="badge badge-pill badge-warning" style="background: #ff5700;margin-right: 10px;">Notice</span> 
        {{ session()->get('warning') }}
    </div>
    @endif
@endsection
