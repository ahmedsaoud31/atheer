<div class="row row-cards">
	<div class="col-12">
	  <div class="card">
	    <div class="card-header">
	      <a href="{{ route("{$route}.create") }}" class="btn btn-primary">{{ __("Create new {$name}") }}</a>
	    </div>
	    <div class="table-responsive">
	      <table class="table card-table table-vcenter text-nowrap datatable">
	        <thead>
	          <tr>
	            <th>ID</th>
	            <th>{{ __('Title') }}</th> <th>{{ __('Body') }}</th>
	            <th></th>
	          </tr>
	        </thead>
	        <tbody>
	        	@foreach($records as $record)
	        		@include("{$path}.tables.row")
	        	@endforeach
	        </tbody>
	      </table>

	    </div>
	    <div class="card-footer d-flex align-items-center">
	      {{ $records->links() }}
	    </div>
	  </div>
	</div>
</div>