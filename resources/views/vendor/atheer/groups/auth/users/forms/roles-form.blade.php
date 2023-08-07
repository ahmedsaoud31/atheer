@csrf
<x-atheer-components::inputs.hidden name="id" :model="$model" />
<div class="row">
	<x-atheer-components::inputs.MultiToggle class="col col-3" name="roles" :label="'dfff'" :options="$roles" :selections="$selections" />
</div>


