<div class="l-navbar" id="nav-bar" style="z-index: 1000;">
  <nav class="nav">
      <div> <a href="{{ route('billing.portal') }}#" class="nav_logo"> <i class='bx bx-layer nav_logo-icon'></i> <span class="nav_logo-name">{{ config('app.name') }}</span> </a>
          <div class="nav_list"> 
            <a href="{{ route('billing.portal') }}#hero" class="nav_link sb-active"> <i class='bx bxs-dashboard nav_icon' ></i> <span class="nav_name">{{ Bill::lang()->get('portal') }}</span> </a> 
            <a href="{{ route('billing.portal') }}#services" class="nav_link"> <i class='bx bxs-package nav_icon'></i> <span class="nav_name">{{ Bill::lang()->get('features') }}</span> </a> 
            <a href="{{ route('billing.portal') }}#pricing" class="nav_link"> <i class='bx bx-basket nav_icon' ></i> <span class="nav_name">{{ Bill::lang()->get('games') }}</span> </a> 
            <a href="{{ route('billing.portal') }}#about" class="nav_link"> <i class='bx bx-bookmarks nav_icon'></i> <span class="nav_name">{{ Bill::lang()->get('about') }}</span> </a> 
            <a href="{{ route('billing.portal') }}#faq" class="nav_link"> <i class='bx bx-info-circle nav_icon'></i> <span class="nav_name">{{ Bill::lang()->get('faqs') }}</span> </a> 
            <a href="{{ Bill::settings()->getParam('discord_server') }}" target="_blank" class="nav_link"> <i class='bx bxl-discord-alt nav_icon' ></i> <span class="nav_name">{{ Bill::lang()->get('discord') }}</span> </a> 
          </div>
      </div> 
      <a class="nav_link" onclick="expand()" style="cursor: pointer;"><i class='bx bx-menu nav_icon' ></i> <span class="nav_name">{{ Bill::lang()->get('minimize') }}</span> </a>
  </nav>
</div>