<li class="nav-item {{ !request()->segment(2)?'active':'' }}">
  <a class="nav-link" href="{{ Atheer::url() }}">
      @include('atheer::tabler.icons.svg.home')
      <span class="nav-link-title">
        {{ __('Home') }}
      </span>
    </a>
</li>

@foreach(Atheer::navbarGroups() as $group_name)
  @include('atheer::layouts.navbars.groups.'.$group_name)
@endforeach

<li class="nav-item dropdown">
  <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false" >
    <span class="nav-link-icon d-md-none d-lg-inline-block">
    @include("atheer::tabler.icons.svg.language")
    </span>
    <span class="nav-link-title">
      {{ __('Languages') }}
    </span>
  </a>
  <div class="dropdown-menu">
    <div class="dropdown-menu-columns">
      <div class="dropdown-menu-column">
      @foreach(Atheer::languages() as $lang)
        <a class="dropdown-item" href="{{ url('/change-locale') . '/' . $lang->code }}">
          {{ $lang->nativeName }}
        </a>
      @endforeach
      </div>
    </div>
  </div>
</li>

@include('atheer::layouts.navbars.profile-menu')

