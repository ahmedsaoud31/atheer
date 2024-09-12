@push('js_after')
<script src="{{ Atheer::publicUrl() . '/themes/tabler/libs/tom-select/dist/js/tom-select.base.min.js' }}" defer></script>
@endpush

@push('scripts')
<script>
  $(function(){
    $( "#createModal" ).on("create_loaded", function(event) {
        $('#createModal .simplemde textarea').each(function() {
            let simplemde = new SimpleMDE({
              element: this,
            })
            let name = this.name
            $("#createModal").focus(function () {
              simplemde.codemirror.refresh()
            })
            simplemde.codemirror.on("keyup", function(){
              $('#createModal [name=' + name + ']').val(simplemde.value())
            })
        })
        $('#createModal .tom-select select').each(function() {
          setTomSelect(this)
        })

    })

    $( "#editModal" ).on("edit_loaded", function(event) {
        $('#editModal .simplemde textarea').each(function() {
            let simplemde = new SimpleMDE({
              element: this,
            })
            let name = this.name
            $("#editModal").focus(function () {
              simplemde.codemirror.refresh()
            })
            simplemde.codemirror.on("keyup", function(){
              $('#editModal [name=' + name + ']').val(simplemde.value())
            })
        })
        $('#editModal .tom-select select').each(function() {
          setTomSelect(this)
        })
    })

    function setTomSelect(element){
      window.TomSelect && (new TomSelect(element, {
        copyClassesToDropdown: false,
        dropdownParent: 'body',
        controlInput: '<input>',
        render:{
          item: function(data,escape) {
            return '<div>' + escape(data.text) + '</div>'
            if( data.customProperties ){
              return '<div><span class="dropdown-item-indicator">' + data.customProperties + '</span>' + escape(data.text) + '</div>'
            }
            return '<div>' + escape(data.text) + '</div>'
          },
          option: function(data,escape){
            return '<div>' + escape(data.text) + '</div>'
            if( data.customProperties ){
              return '<div><span class="dropdown-item-indicator">' + data.customProperties + '</span>' + escape(data.text) + '</div>'
            }
            return '<div>' + escape(data.text) + '</div>'
          },
        },
      }))
    }
  })
</script>
@endpush