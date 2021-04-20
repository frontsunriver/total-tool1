<script>
function deleteAddress(address_id) {
  jQuery(function ($) {
  jQuery.ajax({
    beforeSend: function (xhr) { // Add this line
            xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
     },
    url: '{{ URL::to("/delete-address")}}',
    type: "POST",
    data: {'address_id': address_id,"_token": "{{ csrf_token() }}"},

    success: function (res) {
      window.location = 'shipping-address?action=detele';
    },
  });
});
}
</script>
