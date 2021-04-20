<footer class="footer">
    <div class="container">
        <nav class="pull-left">
        </nav>
        <p class="copyright pull-right"></p>
    </div>
</footer>
</div>
</div>


<!--   Core JS Files   -->
<script> var baseurl = "<?php echo base_url(); ?>"; </script>

<!--Main JS Loading in Head-->
<script src="<?php echo base_url(); ?>assets/js/jquery-ui.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/material.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/perfect-scrollbar.jquery.min.js"></script>

<!-- Image Cropper -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropper/3.1.3/cropper.min.js"></script>

<!-- DatePicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.min.js"></script>

<!--  Charts Plugin -->
<script src="<?php echo base_url(); ?>assets/js/chartist.min.js"></script>

<!--  Plugin for the Wizard -->
<script src="<?php echo base_url(); ?>assets/js/jquery.bootstrap-wizard.js"></script>

<!--   Sharrre Library    -->
<script src="<?php echo base_url(); ?>assets/js/jquery.sharrre.js"></script>


<!-- Select Plugin -->
<!-- <script src="<?php echo base_url(); ?>assets/js/jquery.select-bootstrap.js"></script> -->

<!--  DataTables.net Plugin    -->
<script src="<?php echo base_url(); ?>assets/js/jquery.datatables.js"></script>

<!--  Full Calendar Plugin    -->
<script src="<?php echo base_url(); ?>assets/js/fullcalendar.min.js"></script>

<!-- Material Dashboard javascript methods -->
<script src="<?php echo base_url(); ?>assets/js/material-dashboard.js"></script>

<!--  Jquery Sortable Plugin    -->
<script src="<?php echo base_url(); ?>assets/assets/js/jquery-sortable.js"></script>

<!-- Custom JS Files Added -->
<script src="<?php echo base_url(); ?>assets/assets/js/dashboard.js"></script>

<!-- Include Trumbowyg Editor JS -->
<script src="<?php echo base_url(); ?>assets/assets/trumbowyg/dist/trumbowyg.min.js"></script>


<!-- Nice Select -->
<script src="<?php echo base_url(); ?>assets/assets/js/jquery.nice-select.min.js"></script>

<!-- Color Picker -->
<script src="<?php echo base_url(); ?>assets/assets/js/bootstrap-colorpicker.min.js"></script>

<!-- Jquery datatable tools js -->
<script type="text/javascript" src="<?php echo base_url('assets/assets/datatables/js/dataTables.bootstrap4.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/assets/datatables/js/dataTables.buttons.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/assets/datatables/js/buttons.bootstrap4.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/assets/datatables/js/buttons.print.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/assets/datatables/js/pdfmake.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/assets/datatables/js/pdfmake.min.js.map'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/assets/datatables/js/vfs_fonts.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/assets/datatables/js/buttons.flash.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/assets/datatables/js/buttons.html5.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/assets/datatables/js/buttons.colVis.min.js'); ?>"></script>
<script src="<?php echo base_url(); ?>assets/assets/js/iniDatatables.js"></script>

<script>


<?php if ($this->uri->segment(1) == 'dashboard' && $this->uri->segment(2) == '' || $this->uri->segment(1) == 'dashboard' && $this->uri->segment(2) == 'dashboard') { ?>

    /*  **************** Simple Bar Chart - barchart ******************** */

    var dataSimpleBarChart = {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        series: [
            [<?php echo $browse_collect_jan; ?>, <?php echo $browse_collect_feb; ?>, <?php echo $browse_collect_mar; ?>, <?php echo $browse_collect_apr; ?>, <?php echo $browse_collect_may; ?>, <?php echo $browse_collect_jun; ?>, <?php echo $browse_collect_jul; ?>, <?php echo $browse_collect_aug; ?>, <?php echo $browse_collect_sep; ?>, <?php echo $browse_collect_oct; ?>, <?php echo $browse_collect_nov; ?>, <?php echo $browse_collect_dec; ?>],
            [<?php echo $browse_spend_jan; ?>, <?php echo $browse_spend_feb; ?>, <?php echo $browse_spend_mar; ?>, <?php echo $browse_spend_apr; ?>, <?php echo $browse_spend_may; ?>, <?php echo $browse_spend_jun; ?>, <?php echo $browse_spend_jul; ?>, <?php echo $browse_spend_aug; ?>, <?php echo $browse_spend_sep; ?>, <?php echo $browse_spend_oct; ?>, <?php echo $browse_spend_nov; ?>, <?php echo $browse_spend_dec; ?>],
            [<?php echo $browse_collect_jan - $browse_spend_jan; ?>, <?php echo $browse_collect_feb - $browse_spend_feb; ?>, <?php echo $browse_collect_mar - $browse_spend_mar; ?>, <?php echo $browse_collect_apr - $browse_spend_apr; ?>, <?php echo $browse_collect_may - $browse_spend_may; ?>, <?php echo $browse_collect_jun - $browse_spend_jun; ?>, <?php echo $browse_collect_jul - $browse_spend_jul; ?>, <?php echo $browse_collect_aug - $browse_spend_aug; ?>, <?php echo $browse_collect_sep - $browse_spend_sep; ?>, <?php echo $browse_collect_oct - $browse_spend_oct; ?>, <?php echo $browse_collect_nov - $browse_spend_nov; ?>, <?php echo $browse_collect_dec - $browse_spend_dec; ?>]
        ]
    };

    var optionsSimpleBarChart = {
        seriesBarDistance: 10,
        axisX: {
            showGrid: true
        },
        height: '200px'
    };

    var responsiveOptionsSimpleBarChart = [
        ['screen and (max-width: 640px)', {
                seriesBarDistance: 5,
                axisX: {
                    labelInterpolationFnc: function (value) {
                        return value[0];
                    }
                }
            }]
    ];

    var simpleBarChart = Chartist.Bar('#simpleBarChart', dataSimpleBarChart, optionsSimpleBarChart, responsiveOptionsSimpleBarChart);

    //start animation for the Emails Subscription Chart
    md.startAnimationForBarChart(simpleBarChart);

<?php } ?>

    //$.noConflict();
    jQuery(document).ready(function ($) {}); // End Of NoConflict

    /*************** Destroying Scrollbar On Cropper Container *********************/
    $(".cropper-container").perfectScrollbar('destroy');

    /*************** HTML Text Editor Trumbowyg *********************/
    $('textarea').trumbowyg({
        btns: [
            ['viewHTML'],
            ['undo', 'redo'], // Only supported in Blink browsers
            ['formatting'],
            ['strong', 'em'],
            ['link'],
            ['insertImage'],
            ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
            ['unorderedList', 'orderedList'],
            ['horizontalRule'],
            ['removeformat']
        ]
    });

    $(document).ready(function () {

        /******************* On Click Sidebar Hide & Open ***************/
        /*****************************************************************/
        $('a.closeSidebar').on('click', function () {
            $('.sidebar').hide();
            $('.main-panel').attr('style', 'float:right !important; width:100% !important;');
            $('a.closeSidebar i').html('subdirectory_arrow_right');
            $('a.closeSidebar').attr('title', 'Double Click Me To Open');
            $('a.closeSidebar').attr('class', 'navbar-brand view_mainsite openSidebar');
        });

        $(document).on('dblclick', 'a.openSidebar', function () {
            $('.sidebar').show();
            $('.main-panel').attr('style', 'float:right !important; width: calc(100% - 260px); ');
            $('a.openSidebar i').html('subdirectory_arrow_left');
            $('a.openSidebar').attr('title', 'Click Me To Close');
            $('a.openSidebar').attr('class', 'navbar-brand view_mainsite closeSidebar');
        });

        /*****************************************************************/
        /*****************************************************************/

        /******************* Date Picker In Form ************************/
        /*****************************************************************/
        $('.datepicker').datepicker({
            format: 'dd-mm-yyyy'
        });

        /******************* Color Picker In Form ************************/
        /*****************************************************************/
        $('#color').colorpicker();

        /******************* Select Style In Form ************************/
        /*****************************************************************/
        $('.select').niceSelect();

        $('li.active').children("a").children("p").children("i").html("remove_circle");
        $('li.active ul.active').show();
        $('.sidebar-wrapper ul.nav li.active.nav_parent').attr("class", "active");

        $("li.nav_parent").click(function () {

            //Toggle the child but don't include them in the hide selector using .not()
            $('li > ul.nav_child').not($(this).children("ul").toggle(10)).hide();

            var icon = $(this).children("a").children("p").children("i");
            var html = $(this).children("a").children("p").children("i").html();


            if (html == "add_circle") {
                icon.html("remove_circle");
                html = "remove_circle";
                console.log(html);
            } else if (html == "remove_circle") {
                icon.html("add_circle");
                html = "add_circle";
                console.log(html);
            }
        });

    });



/******************************************************************************/
/******************************************************************************/
/******************************************************************************/

    /************************************************/
    /******** Sorting Default Table ******************/
    /************************************************/
    $('.sorted_table').on('click', function () {
        var group = $(".sorted_table").sortable({
            containerSelector: 'table',
            itemPath: '> tbody',
            itemSelector: 'tr',
            placeholder: '<tr class="placeholder"/>',
            delay: 500,
            onDrop: function ($item, container, _super) {
                $("div#loading").delay(500).fadeIn();
                var data = group.sortable("serialize").get();
                var jsonString = JSON.stringify(data, null, ' ');
                _super($item, container);
                $.post(baseurl + 'dashboard/section/sortSection', {sort: jsonString}, function () {
                });
                $("div#loading").delay(500).fadeOut("slow");
                //$('#serialize_output').html(jsonString);
            }
        });
    });

    /************************************************/
    /******** Sorting Menu Table ******************/
    /************************************************/
    $('.sorted_menu_table').on('click', function () {
        var group = $(".sorted_menu_table").sortable({
            containerSelector: 'table',
            itemPath: '> tbody',
            itemSelector: 'tr',
            placeholder: '<tr class="placeholder"/>',
            delay: 500,
            onDrop: function ($item, container, _super) {
                $("div#loading").delay(500).fadeIn();
                var data = group.sortable("serialize").get();
                var jsonString = JSON.stringify(data, null, ' ');
                _super($item, container);
                $.post(baseurl + 'dashboard/menu/sortmenu', {sort: jsonString}, function () {
                });
                $("div#loading").delay(500).fadeOut("slow");
                $('#serialize_output').html(jsonString);
            }
        });
    });

    /************************************************/
    /******** Sorting Gallery Table ******************/
    /************************************************/
    $('.sorted_gallery_table').on('click', function () {
        var group = $(".sorted_gallery_table").sortable({
            containerSelector: 'table',
            itemPath: '> tbody',
            itemSelector: 'tr',
            placeholder: '<tr class="placeholder"/>',
            delay: 500,
            onDrop: function ($item, container, _super) {
                $("div#loading").delay(500).fadeIn();
                var data = group.sortable("serialize").get();
                var jsonString = JSON.stringify(data, null, ' ');
                _super($item, container);
                $.post(baseurl + 'dashboard/website/sortgallery', {sort: jsonString}, function () {
                });
                $("div#loading").delay(500).fadeOut("slow");
                $('#serialize_output').html(jsonString);
            }
        });
    });

    /************************************************/
    /******** Sorting Slider Table ******************/
    /************************************************/
    $('.sorted_slider_table').on('click', function () {
        var group = $(".sorted_slider_table").sortable({
            containerSelector: 'table',
            itemPath: '> tbody',
            itemSelector: 'tr',
            placeholder: '<tr class="placeholder"/>',
            delay: 500,
            onDrop: function ($item, container, _super) {
                $("div#loading").delay(500).fadeIn();
                var data = group.sortable("serialize").get();
                var jsonString = JSON.stringify(data, null, ' ');
                _super($item, container);
                $.post(baseurl + 'dashboard/website/slidersort', {sort: jsonString}, function () {
                });
                $("div#loading").delay(500).fadeOut("slow");
                $('#serialize_output').html(jsonString);
            }
        });
    });

/******************************************************************************/
/******************************************************************************/
/******************************************************************************/

    /************************************************/
    /******** Destroy Cropper On Click Button ******************/
    /************************************************/
    $('.destroy_cropper').on('click', function () {
        $('img#image').cropper('clear');
        $('.ini_cropper_div').show();
        $('.destroy_cropper_div').hide();
    });

    $('.ini_cropper').on('click', function () {
        $('img#image').cropper('crop');
        $('.ini_cropper_div').hide();
        $('.destroy_cropper_div').show();
    });


    /************************************************/
    /******** Default Image Preview *****************/
    /************************************************/
    function previewFile() {
        var preview = document.querySelector('img#image');
        var file = document.querySelector('input[type=file]').files[0];
        var reader = new FileReader();

        reader.addEventListener("load", function () {
            preview.src = reader.result;
        }, false);

        if (file) {
            reader.readAsDataURL(file);
        }

        reader.onload = (function () {

            // Destroy cropper
            $('#image').cropper('destroy');

            // Replace url
            preview.src = reader.result;

            $('#image').cropper({
                aspectRatio: 1 / 1,
                viewMode: 3,
                dragMode: 'move',
                crop: function (e) {
                    // Output the result data for cropping image.
                    $("input#x").val(e.x);
                    $("input#y").val(e.y);
                    $("input#width").val(e.width);
                    $("input#height").val(e.height);
                }
            });

            var x = $("input#x").val();
            console.log(x);

        });
    }

    /************************************************/
    /******** Event Banner Image Cropper **********/
    /************************************************/
    function eventFeaturePhoto() {
        var preview = document.querySelector('img#image');
        var file = document.querySelector('input[type=file]').files[0];
        var reader = new FileReader();

        reader.addEventListener("load", function () {
            preview.src = reader.result;
        }, false);

        if (file) {
            reader.readAsDataURL(file);
        }

        reader.onload = (function () {

            // Destroy cropper
            $('#image').cropper('destroy');

            // Replace url
            preview.src = reader.result;

            $('#image').cropper({
                aspectRatio: 16 / 9,
                viewMode: 3,
                dragMode: 'move',
                crop: function (e) {
                    // Output the result data for cropping image.
                    $("input#x").val(e.x);
                    $("input#y").val(e.y);
                    $("input#width").val(e.width);
                    $("input#height").val(e.height);
                }
            });

            var x = $("input#x").val();
            console.log(x);

        });
    }


    /************************************************/
    /******** Sermon Banner Image Cropper **********/
    /************************************************/
    function sermonFeaturePhoto() {
        var preview = document.querySelector('img#image');
        var file = document.querySelector('input[type=file]').files[0];
        var reader = new FileReader();

        reader.addEventListener("load", function () {
            preview.src = reader.result;
        }, false);

        if (file) {
            reader.readAsDataURL(file);
        }

        reader.onload = (function () {

            // Destroy cropper
            $('#image').cropper('destroy');

            // Replace url
            preview.src = reader.result;

            $('#image').cropper({
                aspectRatio: 16 / 9,
                viewMode: 3,
                dragMode: 'move',
                crop: function (e) {
                    // Output the result data for cropping image.
                    $("input#x").val(e.x);
                    $("input#y").val(e.y);
                    $("input#width").val(e.width);
                    $("input#height").val(e.height);
                }
            });

            var x = $("input#x").val();
            console.log(x);

        });
    }

    /************************************************/
    /******** Seminar Banner Image Cropper **********/
    /************************************************/
    function seminarbanner() {
        var preview = document.querySelector('img#image');
        var file = document.querySelector('input[type=file]').files[0];
        var reader = new FileReader();

        reader.addEventListener("load", function () {
            preview.src = reader.result;
        }, false);

        if (file) {
            reader.readAsDataURL(file);
        }

        reader.onload = (function () {

            // Destroy cropper
            $('#image').cropper('destroy');

            // Replace url
            preview.src = reader.result;

            $('#image').cropper({
                //aspectRatio: 16 / 9,
                viewMode: 3,
                dragMode: 'move',
                crop: function (e) {
                    // Output the result data for cropping image.
                    $("input#x").val(e.x);
                    $("input#y").val(e.y);
                    $("input#width").val(e.width);
                    $("input#height").val(e.height);
                }
            });

            var x = $("input#x").val();
            console.log(x);

        });
    }

    /************************************************/
    /******** Section Banner Image Cropper **********/
    /************************************************/
    function sectionbanner() {
        var preview = document.querySelector('img#image');
        var file = document.querySelector('input[type=file]').files[0];
        var reader = new FileReader();

        reader.addEventListener("load", function () {
            preview.src = reader.result;
        }, false);

        if (file) {
            reader.readAsDataURL(file);
        }

        reader.onload = (function () {

            // Destroy cropper
            $('#image').cropper('destroy');

            // Replace url
            preview.src = reader.result;

            $('#image').cropper({
                aspectRatio: 16 / 9,
                viewMode: 3,
                dragMode: 'move',
                crop: function (e) {
                    // Output the result data for cropping image.
                    $("input#x").val(e.x);
                    $("input#y").val(e.y);
                    $("input#width").val(e.width);
                    $("input#height").val(e.height);
                }
            });

            var x = $("input#x").val();
            console.log(x);

        });
    }


</script>



</body>
</html>
