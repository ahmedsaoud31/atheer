<div class="nav-item dropdown">
  <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
    <span class="avatar avatar-sm" style="background-image: url({{ Atheer::publicUrl() }}/static/avatars/1.png)"></span>
    <div class="d-none d-xl-block ps-2">
      <div>{{ auth()->user()->name }}</div>
      <div class="mt-1 small text-muted">{{ auth()->user()->email }}</div>
    </div>
  </a>
  <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
    <!--
    <a href="#" class="dropdown-item">{{ __('Set status') }}</a>
    <a href="#" class="dropdown-item">{{ __('Profile & account') }}</a>
    <a href="#" class="dropdown-item">{{ __('Feedback') }}</a>
    <div class="dropdown-divider"></div>
    <a href="#" class="dropdown-item">{{ __('Settings') }}</a>
    -->
    <a href="{{ route('atheer.logout') }}" class="dropdown-item">{{ __('Logout') }}</a>
  </div>
</div>