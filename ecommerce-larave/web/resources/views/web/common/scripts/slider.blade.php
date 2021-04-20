<script>

jQuery(function () {

var $range = jQuery(".js-range-slider"),
    $inputFrom = jQuery(".js-input-from"),
    $inputTo = jQuery(".js-input-to"),
    instance,
    min = 0,
    max = {{$result['filters']['maxPrice']}},
    from = 0,
    to = 0;
$range.ionRangeSlider({
    type: "double",
    min: min,
    max: max,
    from: <?php if($result['min_price'] == ''){echo 0;}else{echo $result['min_price'];} ?>,
    to: <?php if($result['max_price'] == ''){echo $result['filters']['maxPrice'];}else{echo $result['max_price'];} ?>,
  prefix: 'Rp. ',
    onStart: updateInputs,
    onChange: updateInputs,
    step: 1,
    prettify_enabled: true,
    prettify_separator: ".",
  values_separator: " - ",
  force_edges: true


});

instance = $range.data("ionRangeSlider");

function updateInputs (data) {
    from = data.from;
    to = data.to;

    $inputFrom.prop("value", from);
    $inputTo.prop("value", to);
}

    $inputFrom.on("input", function () {
        var val = $(this).prop("value");

        // validate
        if (val < min) {
            val = min;
        } else if (val > to) {
            val = to;
        }

        instance.update({
            from: val
        });
    });

    $inputTo.on("input", function () {
        var val = $(this).prop("value");

        // validate
        if (val < from) {
            val = from;
        } else if (val > max) {
            val = max;
        }

        instance.update({
            to: val

        });
    });

  });

  function getComboA(selectObject) {
    var value = selectObject.value;
  console.log(value);
}
</script>
