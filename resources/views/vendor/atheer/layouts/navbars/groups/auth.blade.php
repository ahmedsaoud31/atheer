@php($active = (request()->segment(2) == $group_name))
<li class="nav-item dropdown {{ $active ? 'active' : '' }}">
  <a class="nav-link dropdown-toggle {{ $active ? 'show' : '' }}" href="#" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="{{ $active ? 'true' : 'false' }}" >
    <span class="nav-link-icon d-md-none d-lg-inline-block">
    @include("atheer::tabler.icons.svg.star")
    </span>
    <span class="nav-link-title">
      {{ __(' Auth') }}
    </span>
  </a>
  <div class="dropdown-menu {{ $active && in_array(config('atheer.layout'), config('atheer.vertical_layouts')) ? 'show' : '' }}">
    <div class="dropdown-menu-columns">
      <div class="dropdown-menu-column">
      @foreach(Atheer::navbarItems($group_name) as $item_name)
      	@include('atheer::layouts.navbars.groups.'.$group_name.'.'.$item_name)
      @endforeach
      </div>
    </div>
  </div>
</li>