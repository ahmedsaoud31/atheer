@push('scripts')
<script>
  $(function() {
    $('#atheerTable').on('click', '.delete', function(){
      var _this = $(this)
      if(!ajax) return false
      var id = _this.parents('.table-row').attr('data-id')
      Swal.fire({
        title: "{{ __('Are you sure?') }}",
        text: "{{ __('You will not be able to revert this!') }}",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: "{{ __('Yes, delete it!') }}",
        cancelButtonText: "{{ __('Cancel') }}"
      }).then((result) => {
        if (result.isConfirmed) {
          var sendData = {
                          "_token": "{{ csrf_token() }}"
                          }
          $.ajax({
              type: "DELETE",
              url: "{{ route("{$atheer->route}.index") }}/" + id,
              data: sendData,
              beforeSend: function(xhr){
                _this.find('.spinner-border').removeClass('d-none').addClass('d-inline')
                $('#spinner').show()
              },
              error: function (xhr){
                if(xhr.status == 499){
                  toastr.error(xhr.responseJSON.message)
                }else{
                  toastr.error(xhr.status + ': ' + xhr.statusText)
                }
                _this.find('.spinner-border').removeClass('d-inline').addClass('d-none')
                $('#spinner').hide()
              }
              }).done(function(data, textStatus, xhr){
                if(xhr.status != 200){
                  toastr.error(data.message)
                }else{
                  $('#atheerTable #row' + id).css({ backgroundColor: "#FFCDD2"})
                  $('#atheerTable #row' + id).fadeOut(500)
                  toastr.success(data.message)
                }
                _this.find('.spinner-border').removeClass('d-inline').addClass('d-none')
                $('#spinner').hide()
          })
        }
      })
      return false
    })
  })
</script>
@endpush