<tr class="table-row" data-id="{{ $record->id }}" id="row{{ $record->id }}">
  <td>{{ $record->id ?? '' }}</td>
  <td>{{ Str::limit($record->name, 30, "...") }}</td>
	<td>{{ Str::limit($record->title, 30, "...") }}</td>
	<td>{{ Str::limit($record->body, 30, "...") }}</td>
	<td>{{ Str::limit($record->alert, 30, "...") }}</td>
	
  <td class="text-end">
    <div class="dropdown">
          <button class="btn btn btn-primary dropdown-toggle align-text-top" data-bs-toggle="dropdown" aria-expanded="true">
            @include("atheer::tabler.icons.svg.settings")
          </button>
          <div class="dropdown-menu dropdown-menu-end" data-popper-placement="bottom-end">
              <!-- If you want to customise actions copy content of "atheer::support.templates.tables.actions" here and customise it -->
              @include('atheer::support.templates.tables.actions')
          </div>
        </div>
  </td>
</tr>