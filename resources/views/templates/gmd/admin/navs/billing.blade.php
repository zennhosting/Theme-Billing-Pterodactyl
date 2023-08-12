<li class="header">Billing Module</li>
<li class="{{ ! starts_with(Route::currentRouteName(), 'admin.billing') ?: 'active' }}">
    <a href="{{ route('admin.billing') }}">
        <i class="fa fa-cog"></i> <span>General</span>
    </a>
</li>

<li class="{{ ! starts_with(Route::currentRouteName(), 'admin.tickets') ?: 'active' }}">
    <a href="{{ route('admin.tickets') }}">
        <i class="fa fa-ticket"></i> <span>Tickets</span>
    </a>
</li>



