<div class="dropdown-menu-column">
  <a class="dropdown-item" href="{{ route("atheer.{$group_name}.{$item_name}.index") }}">
    {{ __(ucfirst($item_name)) }}
    @if(false)
    <span class="badge badge-sm bg-green text-uppercase ms-2">{{ __("New") }}</span>
    @endif
  </a>
</div>