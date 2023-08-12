@section('theme::nav')
    <div class="row">
        <div class="col-xs-12">
            <div class="nav-tabs-custom nav-tabs-floating">
                <ul class="nav nav-tabs">
                    <li @if($activeTab === 'theme')class="active"@endif><a href="{{ route('admin.theme') }}">General Settings</a></li>
                    <li @if($activeTab === 'color')class="active"@endif><a href="{{ route('admin.theme.color') }}">Color Settings</a></li>
                    <li @if($activeTab === 'meta')class="active"@endif><a href="{{ route('admin.theme.meta') }}">Meta Settings</a></li>
                    <li @if($activeTab === 'button')class="active"@endif><a href="{{ route('admin.theme.button') }}">Buttons & Input</a></li>
                    <li @if($activeTab === 'element')class="active"@endif><a href="{{ route('admin.theme.element') }}">Elements Manager</a></li>
                    <li @if($activeTab === 'alert')class="active"@endif><a href="{{ route('admin.theme.alert') }}">Alert Manager</a></li>
                    <li @if($activeTab === 'social')class="active"@endif><a href="{{ route('admin.theme.social') }}">Social Manager</a></li>
                </ul>
            </div>
        </div>
    </div>
@endsection
