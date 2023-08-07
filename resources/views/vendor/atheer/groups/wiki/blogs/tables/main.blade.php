<div class="row row-cards">
	<div class="col-12">
	  <div class="card">
	    <div class="card-header" id="atheerCreate">
	      <a href="{{ route("{$atheer->route}.create") }}" class="btn btn-primary create">
	      	{{ __("Create") }} {{ __($atheer->name) }} {{ __("new") }}
	      	<div class="spinner-border spinner-border-sm m-0 ms-auto d-none"></div>
	      </a>
	    </div>
	    <div class="table-responsive">
	      <table id="atheerTable" class="table card-table table-vcenter text-nowrap datatable">
	        <thead>
	          <tr>
	            <th>{{ __('id') }}</th>
	            <th>{{ __('Name') }}</th>
				<th>{{ __('Title') }}</th>
				<th>{{ __('Body') }}</th>
				<th>{{ __('Alert') }}</th>
				
	            <th></th>
	          </tr>
	        </thead>
	        <tbody>
	        	@foreach($records as $record)
	        		@include("{$atheer->view}.tables.row")
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