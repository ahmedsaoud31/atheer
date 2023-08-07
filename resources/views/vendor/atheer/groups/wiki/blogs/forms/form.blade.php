@csrf
<x-atheer-components::inputs.input class="mb-3" name="name" :label="__('Name')" :placeholder="__('Enter').' '.__('name').' ...'" :model="$model" />
<x-atheer-components::inputs.input class="mb-3" name="title" :label="__('Title')" :placeholder="__('Enter').' '.__('title').' ...'" :model="$model" />
<x-atheer-components::inputs.textarea class="mb-3" name="body" :label="__('Body')" :placeholder="__('Enter').' '.__('body').' ...'" :model="$model" />
<x-atheer-components::inputs.select class="mb-3" name="alert" :label="__('Alert')" :placeholder="__('Choose').' '.__('alert')" :model="$model" :options="Atheer::optionsFormat(['error' => 'Error','warning' => 'Warning','success' => 'Success','info' => 'Info',])" :preoptions="[]"/>
