<script>
function myFunction2(currency_id) {
 jQuery(function ($) {
  jQuery.ajax({
    beforeSend: function (xhr) { // Add this line
            xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
     },
    url: '{{ URL::to("/change_currency")}}',
    type: "POST",
    data: {"currency_id":currency_id,"_token": "{{ csrf_token() }}"},
    success: function (res) {
      window.location.reload();
    },
  });
});
}
</script>
