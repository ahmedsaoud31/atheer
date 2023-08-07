<div class="text-center text-muted mt-3">
  @foreach(Atheer::languages() as $lang)
    <a class="btn btn-outline-primary" href="{{ url('/change-locale') . '/' . $lang->code }}">
      {{ $lang->nativeName }}
    </a>
  @endforeach
</div>