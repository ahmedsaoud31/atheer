@push('scripts')
<script>
  
  $(function() {
    fValidation().setPublicErrorHeader('{{ __("Please fix form validation") }}')

    $('#atheerCreate').on('click', '.create', function(){
      let _this = $(this)
      if(!ajax) return false
      let sendData = {"_token": "{{ csrf_token() }}"}
      $.ajax({
          type: "GET",
          url: "{{ route("{$atheer->route}.index") }}/create",
          data: sendData,
          beforeSend: function(xhr){
            $('#createModal .modal-body').find('.alert-danger').html("").removeClass('d-block').addClass('d-none')
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
              $('#createModal form').html(data.body)
              $('#createModal').modal('toggle')
              $("#createModal").trigger( "create_loaded", [])
            }
            _this.find('.spinner-border').removeClass('d-inline').addClass('d-none')
            $('#spinner').hide()
      })
      return false
    })

    $('#createModal').on('click', '.submit', function(){
      let _this = $(this)
      $.ajax({
          type: "POST",
          url: "{{ route("{$atheer->route}.index") }}",
          data: $("#createModal form").serialize(),
          beforeSend: function(xhr){
            _this.find('.spinner-border').removeClass('d-none').addClass('d-inline')
            $('#spinner').show()
          },
          error: function (xhr){
            if(xhr.status == 499){
              toastr.error(xhr.responseJSON.message)
            }else if(xhr.status == 422){
              toastr.warning('{{ __('Validate input data') }}')
              fValidation('#createModal', xhr.responseJSON.errors).validate()
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
              $('#atheerTable tbody').prepend(data.body);
              $('#atheerTable #row' + data.id).css({ backgroundColor: "#C8E6C9"})
              $('#createModal').modal('toggle')
              toastr.success(data.message)
            }
            _this.find('.spinner-border').removeClass('d-inline').addClass('d-none')
            $('#spinner').hide()
      })
      return false
    })
  })
</script>
@endpush