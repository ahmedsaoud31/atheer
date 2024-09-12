@push('scripts')
<script>
  $(function() {

    fValidation().setPublicErrorHeader('{{ __("Please fix form validation") }}')
    
    $('#atheerTable').on('click', '.edit', function(){
      let _this = $(this)
      if(!ajax) return false
      let sendData = {
                      "_token": "{{ csrf_token() }}"
                      }
      let id = _this.parents('.table-row').attr('data-id')
      $.ajax({
          type: "GET",
          url: "{{ route("{$atheer->route}.index") }}/" + id + "/edit",
          data: sendData,
          beforeSend: function(xhr){
            $('#editModal .modal-body').find('.alert-danger').html("").removeClass('d-block').addClass('d-none')
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
              toastr.error(data.message);
            }else{
              $('#editModal form').html(data.body)
              $('#editModal .submit').attr('data-id', id)
              $('#editModal').modal('toggle')
              $("#editModal").trigger( "edit_loaded", [])
            }
            _this.find('.spinner-border').removeClass('d-inline').addClass('d-none')
            $('#spinner').hide()
      })
      return false
    })

    $('#editModal').on('click', '.submit', function(){
      let _this = $(this)
      $.ajax({
          type: "PUT",
          url: "{{ route("{$atheer->route}.index") }}/" + _this.attr('data-id'),
          data: $("#editModal form").serialize(),
          beforeSend: function(xhr){
            _this.find('.spinner-border').removeClass('d-none').addClass('d-inline')
            $('#spinner').show()
          },
          error: function (xhr){
            if(xhr.status == 499){
              toastr.error(xhr.responseJSON.message)
            }else if(xhr.status == 422){
              toastr.warning('{{ __('Validate input data') }}')
              fValidation('#editModal', xhr.responseJSON.errors).validate()
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
              $('#atheerTable #row' + _this.attr('data-id')).replaceWith(data.body)
              $('#atheerTable #row' + _this.attr('data-id')).css({ backgroundColor: "#B3E5FC"})
              $('#editModal').modal('toggle')
              toastr.info(data.message)
            }
            _this.find('.spinner-border').removeClass('d-inline').addClass('d-none')
            $('#spinner').show()
      })
      return false
    });

  });
</script>
@endpush