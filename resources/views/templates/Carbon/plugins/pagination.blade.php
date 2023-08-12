<nav aria-label="page-number">
  <ul class="pagination" style="justify-content: center;">

    <li class="page-item @if ($p == 1) disabled @endif">
      <a class="page-link" href="{{$url}}{{$p - 1}}">
        <i class="fa fa-angle-left"></i>
        <span class="sr-only">Previous</span>
      </a>
    </li>

    @if($p >= 8) <li class="page-item"><a class="page-link" href="{{$url}}{{$p - 7}}">{{$p - 7}}</a></li> @endif
    @if($p >= 7) <li class="page-item"><a class="page-link" href="{{$url}}{{$p - 6}}">{{$p - 6}}</a></li> @endif
    @if($p >= 6) <li class="page-item"><a class="page-link" href="{{$url}}{{$p - 5}}">{{$p - 5}}</a></li> @endif
    @if($p >= 5) <li class="page-item"><a class="page-link" href="{{$url}}{{$p - 4}}">{{$p - 4}}</a></li> @endif
    @if($p >= 4) <li class="page-item"><a class="page-link" href="{{$url}}{{$p - 3}}">{{$p - 3}}</a></li> @endif
    @if($p >= 3) <li class="page-item"><a class="page-link" href="{{$url}}{{$p - 2}}">{{$p - 2}}</a></li> @endif
    @if($p >= 2) <li class="page-item"><a class="page-link" href="{{$url}}{{$p - 1}}">{{$p - 1}}</a></li> @endif


    <li class="page-item active"><a class="page-link" href="#">{{$p}}</a></li>
    <li class="page-item"><a class="page-link" href="{{$url}}{{$p + 1}}">{{$p + 1}}</a></li>
    <li class="page-item"><a class="page-link" href="{{$url}}{{$p + 2}}">{{$p + 2}}</a></li>
    <li class="page-item"><a class="page-link" href="{{$url}}{{$p + 3}}">{{$p + 3}}</a></li>
    <li class="page-item"><a class="page-link" href="{{$url}}{{$p + 4}}">{{$p + 4}}</a></li>
    <li class="page-item"><a class="page-link" href="{{$url}}{{$p + 5}}">{{$p + 5}}</a></li>
    <li class="page-item"><a class="page-link" href="{{$url}}{{$p + 6}}">{{$p + 6}}</a></li>
    <li class="page-item"><a class="page-link" href="{{$url}}{{$p + 7}}">{{$p + 7}}</a></li>

    @if($p <= 7) <li class="page-item"><a class="page-link" href="{{$url}}{{$p + 8}}">{{$p + 8}}</a></li> @endif
    @if($p <= 6) <li class="page-item"><a class="page-link" href="{{$url}}{{$p + 9}}">{{$p + 9}}</a></li> @endif
    @if($p <= 5) <li class="page-item"><a class="page-link" href="{{$url}}{{$p + 10}}">{{$p + 10}}</a></li> @endif
    @if($p <= 4) <li class="page-item"><a class="page-link" href="{{$url}}{{$p + 11}}">{{$p + 11}}</a></li> @endif
    @if($p <= 3) <li class="page-item"><a class="page-link" href="{{$url}}{{$p + 12}}">{{$p + 12}}</a></li> @endif
    @if($p <= 2) <li class="page-item"><a class="page-link" href="{{$url}}{{$p + 13}}">{{$p + 13}}</a></li> @endif
    @if($p <= 1) <li class="page-item"><a class="page-link" href="{{$url}}{{$p + 14}}">{{$p + 14}}</a></li> @endif


    <li class="page-item">
      <a class="page-link" href="{{$url}}{{$p + 1}}">
        <i class="fa fa-angle-right"></i>
        <span class="sr-only">Next</span>
      </a>
    </li>
  </ul>
</nav>
