@php($name = 'users')
<li class="nav-item {{ request()->page == $name?'active':'' }}">
  <a class="nav-link" href="{{ $menu->href }}" >
    <span class="nav-link-icon d-md-none d-lg-inline-block">
    @include("atheer::icons.svg.star)
    </span>
    <span class="nav-link-title">
      {{ __($name) }}
    </span>
  </a>
</li>