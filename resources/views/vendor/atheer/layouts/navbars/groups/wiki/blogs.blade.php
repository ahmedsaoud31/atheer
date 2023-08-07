@if(auth()->user()->can("view {$item_name}") || auth()->user()->hasRole('Super Admin'))
<a class="dropdown-item {{ request()->segment(3) == $item_name ? 'active' : '' }}" href="{{ route("atheer.{$group_name}.{$item_name}.index") }}">
  {{ __(ucfirst($item_name)) }}
</a>
@endif