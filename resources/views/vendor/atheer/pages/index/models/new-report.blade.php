<div class="modal modal-blur fade" id="modal-report" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">{{ __('New report') }} {{ route('atheer.wiki.blogs.edit', 20) }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <x-atheer-components::inputs.input class="mb-3" name="name" :label="__('Name label')" :placeholder="__('Name placeholder')" />
        <label class="form-label">{{ __('Report type') }}</label>
        <div class="form-selectgroup-boxes row mb-3">
          <div class="col-lg-6">
            <label class="form-selectgroup-item">
              <input type="radio" name="report-type" value="1" class="form-selectgroup-input" checked>
              <span class="form-selectgroup-label d-flex align-items-center p-3">
                <span class="me-3">
                  <span class="form-selectgroup-check"></span>
                </span>
                <span class="form-selectgroup-label-content">
                  <span class="form-selectgroup-title strong mb-1">{{ __('Simple') }}</span>
                  <span class="d-block text-muted">{{ __('Provide only basic data needed for the report') }}</span>
                </span>
              </span>
            </label>
          </div>
          <div class="col-lg-6">
            <label class="form-selectgroup-item">
              <input type="radio" name="report-type" value="1" class="form-selectgroup-input">
              <span class="form-selectgroup-label d-flex align-items-center p-3">
                <span class="me-3">
                  <span class="form-selectgroup-check"></span>
                </span>
                <span class="form-selectgroup-label-content">
                  <span class="form-selectgroup-title strong mb-1">{{ __('Advanced') }}</span>
                  <span class="d-block text-muted">{{ __('Insert charts and additional advanced analyses to be inserted in the report') }}</span>
                </span>
              </span>
            </label>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-8">
            <div class="mb-3">
              <label class="form-label">{{ __('Report url') }}</label>
              <div class="input-group input-group-flat">
                <span class="input-group-text">
                  https://tabler.io/reports/
                </span>
                <input type="text" class="form-control ps-0"  value="report-01" autocomplete="off">
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <x-atheer-components::inputs.select class="mb-3" name="visibility" :label="__('Visibility label')" :placeholder="__('Visibility placeholder')" />
          </div>
        </div>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-6">
            <x-atheer-components::inputs.input class="mb-3" name="client_name" :label="__('Client name label')" :placeholder="__('Client name placeholder')" />
          </div>
          <div class="col-lg-6">
            <x-atheer-components::inputs.input class="mb-3" name="date" type="date" :label="__('Reporting period label')" />
          </div>
          <div class="col-lg-12">
            <x-atheer-components::inputs.textarea name="information" :label="__('Additional information label')" :placeholder="__('Additional information placeholder')" />
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
          {{ __('Cancel') }}
        </a>
        <a href="#" class="btn btn-primary ms-auto" data-bs-dismiss="modal">
          @include('atheer::icons.svg.plus')
          {{ __('Create new report') }}
        </a>
      </div>
    </div>
  </div>
</div>