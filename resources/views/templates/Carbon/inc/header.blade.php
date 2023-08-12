@inject('Cache', 'Illuminate\Support\Facades\Cache')
<!DOCTYPE html>
<header>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
  <link rel="stylesheet" href="/themes/carbon/css/style.min.css" type="text/css">
  <link rel="stylesheet" href="/themes/carbon/css/interchanging.css" type="text/css">
  <link rel="stylesheet" href="/themes/carbon/css/core.css" type="text/css">

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="@isset($server)@else/themes/carbon/js/buttons.js @endisset"></script>


  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

  <meta property="og:title" content="@if(isset($settings['meta_title'])){{ $settings['meta_title'] }}@else {{ config('app.name') }} @endif">
  <meta property="og:type" content="website">
  <meta property="og:url" content="/">
  <meta property="og:image" content="@if(isset($settings['meta_image'])){{ $settings['meta_image'] }}@else https://cdn.resourcemc.net/zAsa7/rIBOyeRU58.png/raw @endif">
  <meta property="og:description" content="@if(isset($settings['meta_desc'])){{ $settings['meta_desc'] }}@else Manage your server with an easy-to-use Panel @endif">
  <meta name="theme-color" content="@if(isset($settings['meta_color'])){{ $settings['meta_color'] }}@else #0e4688 @endif">

  
</header>

<!--Preloader-->
@isset($settings['preloader'])@if( $settings['preloader'] == "false") @else <div id="preloader"></div>  @endif @else <div id="preloader"></div> @endisset

<body id="body-pd">

  <div class="header" id="header" style="z-index: 33;">
  <div class="header_toggle"> <i class='bx bx-menu' id="header-toggle" style="margin-right: 15px;"></i> </div>
    <form onClick="Search()" class="navbar-search navbar-search-light form-inline mr-sm-3" id="navbar-search-main">
        <div class="form-group mb-0">
          <div class="input-group input-group-alternative input-group-merge">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="fas fa-search"></i></span>
            </div>
            <input class="form-control" placeholder="Search" type="text">
          </div>
        </div>
        <button type="button" class="close" data-action="search-close" data-target="#navbar-search-main" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
    </form>

  <ul class="navbar-nav align-items-center ml-auto ml-md-0 d-inline">

    <ul class="nav-item dropdown navbar-nav align-items-end ml-auto ml-md-0 mr-3">
      <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <div class="media align-items-center">
          <span class="img-thumbnail" style="border: 0 none; box-shadow: none;">
            <img src="https://flagcdn.com/32x24/{{ Bill::lang()->getActiveLang() }}.png" alt="">
          </span>
          <div class="media-body  ml-2  d-none d-lg-block">
            <span class="mb-0 text-sm  font-weight-bold">
              {{ Bill::lang()->get(Bill::lang()->getActiveLang()) }}
            </span>
          </div>
        </div>
      </a>
      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
        @foreach(Bill::lang()->getAll() as $key => $value)
        <a class="dropdown-item" href="{{ route('billing.toggle.lang', ['lang' => $key]) }}">
          <div class="media align-items-center">
            <span class="">
              <img src="https://flagcdn.com/32x24/{{ $key }}.png" alt="">
            </span>
            <div class="media-body  ml-2  d-none d-lg-block">
              <span class="mb-0 text-sm  font-weight-bold">
                {{ Bill::lang()->get($key) }}
              </span>
            </div>
          </div>
        </a>
        @endforeach
      </div>
    </ul>

      <li class="nav-item dropdown" style="width: auto;">
        <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <div class="media align-items-center">
            <span class="avatar avatar-sm rounded-circle">
              <img src="https://www.gravatar.com/avatar/{{ md5(strtolower(Auth::user()->email)) }}?s=160" alt="">
            </span>
            <div class="media-body  ml-2  d-none d-lg-block">
              <span class="mb-0 text-sm  font-weight-bold">
              {{ Auth::user()->name_first }} {{ Auth::user()->name_last }} <i class='bx bx-caret-down' ></i>
              </span>
            </div>
          </div>
        </a>
        <div class="dropdown-menu dropdown-menu-right">
          <div class="dropdown-header noti-title">
            <h6 class="text-overflow m-0"><strong>{{ Auth::user()->email }}</strong></h6>
          </div>
          <a href="/account" class="dropdown-item">
          <i class='bx bx-user' ></i>
            <span>{!! Bill::lang()->get('account_page') !!}</span>
          </a>
          <a href="/account/activity" class="dropdown-item">
            <i class='bx bx-group' ></i>
              <span>Account Activity</span>
            </a>
          <a style=" @if(!config('billing.billing')) display: none !important; @endif " href="{{ route('billing.balance') }}" class="dropdown-item">
            <i class='bx bx-wallet'></i>
              <span>{!! Bill::lang()->get('billing_balance') !!}</span>
            </a>
            <a href="/account/ssh" class="dropdown-item">
              <i class='bx bx-terminal'></i>
                <span>SSH Keys</span>
              </a>
          <a href="/account/api" class="dropdown-item">
            <i class='bx bx-code-alt' ></i>
            <span>{!! Bill::lang()->get('account_api') !!}</span>
          </a>
          @if(Auth::user()->root_admin)
          <a href="/admin" class="dropdown-item">
           <i class='bx bx-key'></i>
            <span>{!! Bill::lang()->get('admin_area') !!}</span>
          </a>
          @endif
          @if(Bill::allowed('affiliates'))
          <a href="{{route('billing.affiliate')}}" class="dropdown-item">
          <i class='bx bx-share-alt'></i>
            <span>Affiliate Program</span>
          </a> 
          @endif
          <div class="dropdown-divider"></div>
          <a href="{{ route('billing.toggle.mode') }}" class="dropdown-item" style="display: flex;align-items: center;">
            <i class='bx bx-adjust' ></i>
              {!! Bill::lang()->get('dark_mode') !!}
               <span style="padding-left: 10px;">
                <label class="custom-toggle">
                  <input onclick="location.href = '{{ route('billing.toggle.mode') }}';" type="checkbox" @if($Cache::get('carbondarckmode' . Auth::user()->id) == 'on') checked @endif>
                  <span class="custom-toggle-slider rounded-circle" data-label-off="OFF" data-label-on="ON"></span>
                </label>
              </span>
            </a>
          <a href="{{ route('auth.logout') }}" class="dropdown-item">
          <i class='bx bx-power-off'></i>
            <span>{!! Bill::lang()->get('logout') !!}</span>
          </a>
        </div>
      </li>
    </ul>
</div>