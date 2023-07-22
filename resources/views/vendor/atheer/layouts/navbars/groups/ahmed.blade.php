<li class="nav-item dropdown {{ request()->page == $group_name?'active':'' }}">
  <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false" >
    <span class="nav-link-icon d-md-none d-lg-inline-block">
    @include("atheer::icons.svg.star")
    </span>
    <span class="nav-link-title">
      {{ __(ucfirst($group_name)) }}
    </span>
  </a>
  <div class="dropdown-menu">
    <div class="dropdown-menu-columns">
      @foreach(Atheer::navbarItems($group_name) as $item_name)
      	@include('atheer::layouts.navbars.groups.'.$group_name.'.'.$item_name)
      @endforeach
    </div>
  </div>
</li>