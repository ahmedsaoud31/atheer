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

<li class="nav-item">
  <a class="nav-link" href="{{ url('/change-locale') . '/' . (app()->getLocale() == 'en' ? 'ar' : 'en') }}">
      @include('atheer::tabler.icons.svg.language')
      <span class="nav-link-title">
        @if(app()->getLocale() == 'en')
        العربية
        @else
        English
        @endif
      </span>
    </a>
</li>