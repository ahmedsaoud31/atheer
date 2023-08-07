@push('scripts')
<script>
  $(function() {

    fValidation().setPublicErrorHeader('{{ __("Please fix form validation") }}');
    
    $('#atheerTable').on('click', '.attach', function(){
      var _this = $(this);
      if(!ajax) return;
      var id = _this.parents('.table-row').attr('data-id');
      var sendData = {
                      "_token": "{{ csrf_token() }}",
                      "id": id,
                      };
      $.ajax({
          type: "GET",
          url: "{{ route("{$atheer->route}.index") }}/roles",
          data: sendData,
          beforeSend: function(xhr){
            $('#attachModal .modal-body').find('.alert-danger').html("").removeClass('d-block').addClass('d-none');
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
              $('#attachModal form').html(data.body);
              $('#attachModal .submit').attr('data-id', id);
              $('#attachModal').modal('toggle');
            }
            _this.find('.spinner-border').removeClass('d-inline').addClass('d-none');
      });
      return false;
    });

    $('#attachModal').on('click', '.submit', function(){
      var _this = $(this);
      $.ajax({
          type: "POST",
          url: "{{ route("{$atheer->route}.index") }}/update-roles",
          data: $("#attachModal form").serialize(),
          beforeSend: function(xhr){
            _this.find('.spinner-border').removeClass('d-none').addClass('d-inline');
          },
          error: function (xhr){
            if(xhr.status != 422){
              toastr.error(xhr.status + ': ' + xhr.responseJSON.message);
            }else{
              $('#attachModal .modal-body').find('.alert-danger').html("{{ __('Please fix form validation.') }}").removeClass('d-none').addClass('d-block');
            }
            _this.find('.spinner-border').removeClass('d-inline').addClass('d-none');
            fValidation('#attachModal', xhr.responseJSON.errors).validate();
          }
          }).done(function(data, textStatus, xhr){
            if(xhr.status != 200){
              toastr.error(data.message);
            }else{
              $('#atheerTable #row' + _this.attr('data-id')).replaceWith(data.body);
              $('#atheerTable #row' + _this.attr('data-id')).css({ backgroundColor: "#B3E5FC"});
              $('#attachModal').modal('toggle');
              toastr.info(data.message);
            }
            $('#attachModal .modal-body').find('.alert-danger').html("").removeClass('d-block').addClass('d-none');
            _this.find('.spinner-border').removeClass('d-inline').addClass('d-none');
      });
      return false;
    });

  });
</script>
@endpush