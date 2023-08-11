

<li class="nav-item dropdown d-none d-lg-block">
  <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" data-bs-auto-close="{{ in_array($layout, config('atheer.horizontal_layouts'))?'outside':'false' }}" role="button" aria-expanded="false" >
    <span class="nav-link-icon avatar avatar-sm" style="background-image: url({{ Atheer::publicUrl() }}/static/avatars/1.png)"></span>
    <span class="nav-link-title">
      {{ auth()->user()->name }}
    </span>
  </a>
  <div class="dropdown-menu">
    <div class="dropdown-menu-columns">
      <div class="dropdown-menu-column">
        <a class="dropdown-item" href="{{ route('atheer.logout') }}">
          {{ __('Logout') }}
        </a>
      </div>
    </div>
  </div>
</li>