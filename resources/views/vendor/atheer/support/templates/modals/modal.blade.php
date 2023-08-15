<div class="modal modal-blur fade" id="{{ $modalID }}" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">{{ $title }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="alert alert-danger d-none"></div>
        <form>
          
        </form>
      </div>
      <div class="modal-footer">
        <button class="btn btn-link link-secondary" data-bs-dismiss="modal">
          {{ __('Cancel') }}
        </button>
        <button class="btn btn-primary ms-auto submit" data-id="">
          {{ $submitTitle }}
          <div class="spinner-border spinner-border-sm d-none"></div>
        </button>
      </div>
    </div>
  </div>
</div>