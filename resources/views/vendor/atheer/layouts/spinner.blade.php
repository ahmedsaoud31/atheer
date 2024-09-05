<div id="spinner" class="spinner-border text-indigo" style="display: none; position: fixed; z-index: 5000; top:10px; right:10px;" role="status"></div>

<script>
$(document).on({
  ajaxStart: function() {
    $('#spinner').show()
  },
  ajaxStop: function() {
    $('#spinner').hide()
  }
})
</script>