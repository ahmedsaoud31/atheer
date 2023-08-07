@csrf
<x-atheer-components::inputs.input class="mb-3" name="name" :label="__('Name')" :placeholder="__('Enter').' '.__('name').' ...'" :model="$model" />
<x-atheer-components::inputs.input class="mb-3" name="email" :label="__('Email')" :placeholder="__('Enter').' '.__('email').' ...'" :model="$model" />
@if(isset($atheer->form) &&  $atheer->form == 'edit')
<div class="mb-3">
	<div class="alert alert-info">
	{{ __('Leave password empty if you don\'t want change it') }}
	</div>
</div>
@endif
<x-atheer-components::inputs.input class="mb-3" name="password" type="password" :label="__('Password')" :placeholder="__('Enter').' '.__('password').' ...'" :model="$model" />
<x-atheer-components::inputs.input class="mb-3" name="password_confirmation" type="password" :label="__('Password confirmation')" :placeholder="__('Enter').' '.__('password confirmation').' ...'" :model="$model" />
