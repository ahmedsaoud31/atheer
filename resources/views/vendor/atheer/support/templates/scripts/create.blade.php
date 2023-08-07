@push('scripts')
<script>
  $(function() {

    fValidation().setPublicErrorHeader('{{ __("Please fix form validation") }}');

    $('#atheerCreate').on('click', '.create', function(){
      var _this = $(this);
      if(!ajax) return;
      var sendData = {"_token": "{{ csrf_token() }}"};
      $.ajax({
          type: "GET",
          url: "{{ route("{$atheer->route}.index") }}/create",
          data: sendData,
          beforeSend: function(xhr){
            $('#createModal .modal-body').find('.alert-danger').html("").removeClass('d-block').addClass('d-none');
            _this.find('.spinner-border').removeClass('d-none').addClass('d-inline');
          },
          error: function (xhr){
            toastr.error(xhr.status + ': ' + xhr.statusText);
            _this.find('.spinner-border').removeClass('d-inline').addClass('d-none');
          }
          }).done(function(data, textStatus, xhr){
            if(xhr.status != 200){
              toastr.error(data.message);
            }else{
              $('#createModal form').html(data.body);
              $('#createModal').modal('toggle');
            }
            _this.find('.spinner-border').removeClass('d-inline').addClass('d-none');
      });
      return false;
    });

    $('#createModal').on('click', '.submit', function(){
      var _this = $(this);
      $.ajax({
          type: "POST",
          url: "{{ route("{$atheer->route}.index") }}",
          data: $("#createModal form").serialize(),
          beforeSend: function(xhr){
            _this.find('.spinner-border').removeClass('d-none').addClass('d-inline');
          },
          error: function (xhr){
            if(xhr.status != 422){
              toastr.error(xhr.status + ': ' + xhr.responseJSON.message);
            }
            _this.find('.spinner-border').removeClass('d-inline').addClass('d-none');
            fValidation('#createModal', xhr.responseJSON.errors).validate();
            toastr.warning('{{ __('Validate input data') }}');
          }
          }).done(function(data, textStatus, xhr){
            if(xhr.status != 200){
              toastr.error(data.message);
            }else{
              $('#atheerTable tbody').prepend(data.body);
              $('#atheerTable #row' + data.id).css({ backgroundColor: "#C8E6C9"});
              $('#createModal').modal('toggle');
              toastr.success(data.message);
            }
            _this.find('.spinner-border').removeClass('d-inline').addClass('d-none');
      });
      return false;
    });
  });
</script>
@endpush