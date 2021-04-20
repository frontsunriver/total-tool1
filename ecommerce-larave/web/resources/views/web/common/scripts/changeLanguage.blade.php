<script>
function myFunction1(lang_id) {
 jQuery(function ($) {
  jQuery.ajax({
    beforeSend: function (xhr) { // Add this line
            xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
     },
    url: '{{ URL::to("/change_language")}}',
    type: "POST",
    data: {"languages_id":lang_id,"_token": "{{ csrf_token() }}"},
    success: function (res) {
      window.location.reload();
    },
  });
});
}
</script>
