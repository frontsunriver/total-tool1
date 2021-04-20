

<?php
if ($this->uri->uri_string() == '') {
    $home = true;
} else {
    $home = false;
}
?>

<?php foreach ($basicinfo as $basic)

    ?>
<div class="cs_sections">

    <div class="separator-container">
        <div class="extra_space_sm"></div>
    </div>

    <div class="container-fluid">
        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <div class="separator-container">
                <div class="extra_space_xs"></div>
            </div>
            <div class="box height100">
                <div class="box_header">
                    <h4><i class="fa fa-comments fa-fw"></i> About Us</h4>
                </div>

                <div class="box_body">
                    <p><?php echo $basic->about; ?></p>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <div class="separator-container">
                <div class="extra_space_xs"></div>
            </div>
            <div class="box height100">
                <div class="box_header">
                    <h4><i class="fa fa-phone fa-fw"></i> Contact</h4>
                </div>

                <div class="box_body">
                    <p><?php echo $basic->contact; ?></p>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <div class="separator-container">
                <div class="extra_space_xs"></div>
            </div>
            <div class="box height100">
                <div class="box_header">
                    <h4><i class="fa fa-map-marker fa-fw"></i> Address</h4>
                </div>

                <div class="box_body">
                    <p><?php echo $basic->address; ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="separator-container">
        <div class="extra_space_sm"></div>
    </div>

    <div class="footer-below">
        <div class="container-fluid">
            <div class="col-md-4 social_media">
                <a class="socialbtn facebook" target="_blank" href="<?php echo getBasic()->facebook;?>"><i class="fa fa-facebook"></i></a>
                <a class="socialbtn twitter" target="_blank" href="<?php echo getBasic()->twitter;?>"><i class="fa fa-twitter"></i></a>
                <a class="socialbtn linkedin" target="_blank" href="<?php echo getBasic()->linkedin;?>"><i class="fa fa-linkedin"></i></a>
                <a class="socialbtn googleplus" target="_blank" href="<?php echo getBasic()->googleplus;?>"><i class="fa fa-google"></i></a>
                <a class="socialbtn youtube" target="_blank" href="<?php echo getBasic()->youtube;?>"><i class="fa fa-youtube"></i></a>
                <a class="socialbtn pinterest" target="_blank" href="<?php echo getBasic()->pinterest;?>"><i class="fa fa-pinterest"></i></a>
                <a class="socialbtn instagram" target="_blank" href="<?php echo getBasic()->instagram;?>"><i class="fa fa-instagram"></i></a>
                <a class="socialbtn whatsapp" target="_blank" href="tel:<?php echo getBasic()->whatsapp;?>"><i class="fa fa-whatsapp"></i></a>
            </div>

            <div class="col-md-8 copyright">
                <p class="copyright_text">Copyright © <?php echo date("Y"); ?> - <?php echo $basic->title; ?> - <?php echo $basic->tag; ?> - <?php echo strip_tags($basic->copyright); ?></p>
            </div>
        </div>
    </div>


    <a class="scroll" data-scroll href="#scroll-element"><i class="material-icons">arrow_upward</i></a>



</div>
</div>

<?php if($this->uri->segment(2) == "blog" && $this->uri->segment(3) == "view"){ ?>

    <div id="fb-root"></div>
    <script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.12&appId=<?php echo getBasic()->fbappid;?>&autoLogAppEvents=1';
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>

<?php } ?>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>

<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="<?php echo base_url(); ?>assets/assets/js/modernizr-2.8.3.min.js"></script>
<script src="<?php echo base_url(); ?>assets/assets/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/assets/js/parallax.js"></script>
<script src="<?php echo base_url(); ?>assets/assets/js/animations.min.js"></script>
<script src="<?php echo base_url(); ?>assets/assets/js/appear.min.js"></script>
<script src="<?php echo base_url(); ?>assets/assets/js/jquery.countdown.min.js"></script>
<script src="<?php echo base_url(); ?>assets/assets/js/owl.carousel.min.js"></script>

<!-- Add mousewheel plugin (this is optional) -->
<script src="<?php echo base_url(); ?>assets/assets/fancybox/lib/jquery.mousewheel.pack.js"></script>
<!-- Add Unitegallery -->
<script src="<?php echo base_url(); ?>assets/assets/unitegallery/dist/js/unitegallery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/assets/unitegallery/dist/themes/tiles/ug-theme-tiles.js"></script>

<!-- Add fancyBox -->
<script src="<?php echo base_url(); ?>assets/assets/fancybox/source/jquery.fancybox.pack.js?v=2.1.5"></script>
<script src="<?php echo base_url(); ?>assets/assets/fancybox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>
<script src="<?php echo base_url(); ?>assets/assets/fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>
<script src="<?php echo base_url(); ?>assets/assets/fancybox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>

<!-- Add FullCalendar -->
<script src="<?php echo base_url(); ?>assets/assets/fullcalendar/lib/moment.min.js"></script>
<script src="<?php echo base_url(); ?>assets/assets/fullcalendar/fullcalendar.min.js"></script>

<!-- Include Jssocial JS -->
<script src="<?php echo base_url(); ?>assets/assets/jssocials/jssocials.min.js"></script>

<!-- Include VideoJS JS -->
<script src="https://vjs.zencdn.net/7.1.0/video.js"></script>

<!-- Load The Stripe Js Only if homepage for donation or in cart page for shopping -->
<?php if($this->uri->uri_string() == '' || $this->uri->segment(3) == "cart"){ ?>

    <!--Stripe Script-->
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        // Stripe API Key
        var stripe = Stripe('<?php echo getBasic()->stripe_apikey; ?>');
        var elements = stripe.elements();
        // Custom Styling
        var style = {
            base: {
                color: '#32325d',
                lineHeight: '24px',
                fontFamily: '"Bitter", serif',
                fontSmoothing: 'antialiased',
                fontSize: '16px',
                '::placeholder': {
                    color: '#aab7c4'
                }
            },
            invalid: {
                color: '#fa755a',
                iconColor: '#fa755a'
            }
        };
        // Create an instance of the card Element
        var card = elements.create('card', {style: style});
        // Add an instance of the card Element into the `card-element` <div>
        card.mount('#card-element');
        // Handle real-time validation errors from the card Element.
        card.addEventListener('change', function(event) {
            var displayError = document.getElementById('card-errors');
        if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });
        // Handle form submission
        var form = document.getElementById('payment-form');
        form.addEventListener('submit', function(event) {
            event.preventDefault();
        stripe.createToken(card).then(function(result) {
                if (result.error) {
                    // Inform the user if there was an error
                    var errorElement = document.getElementById('card-errors');
                    errorElement.textContent = result.error.message;
                } else {
                    stripeTokenHandler(result.token);
                }
            });
        });
        // Send Stripe Token to Server
        function stripeTokenHandler(token) {
            // Insert the token ID into the form so it gets submitted to the server
            var form = document.getElementById('payment-form');
        // Add Stripe Token to hidden input
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);
        // Submit form
            form.submit();
        }

    </script>
    <script src="<?php echo base_url(); ?>assets/assets/js/stripecharge.js"></script>

<?php } ?>


<script src="<?php echo base_url(); ?>assets/assets/js/smooth-scroll.js"></script>
<script>
    var scroll = new SmoothScroll('a.scroll', {
        speed: 1000, // Integer. How fast to complete the scroll in milliseconds
        easing: 'easeInOutCubic' // Easing pattern to use
    });

    var num = 200; //number of pixels before modifying styles
    $(window).bind('scroll', function () {
        if ($(window).scrollTop() > num) {
            $('a.scroll').show();
        } else {
            $('a.scroll').hide();
        }
    });

</script>

<script type="text/javascript">

    //Dashboard's and Other Notification Auto Hide FlashData Notification
    $("div#success_notifi").delay(15000).hide("Slow");
    $("div#warning_notifi").delay(15000).hide("Slow");


    $("a.homepage-sermon-video").on('click', function (e) {
        e.preventDefault();
        alert('Its Working');
        $(".homepage-sermon-video-div").hide();
        $(this).parent().parent().parent().children('.homepage-sermon-video-div').show();
    });

    jQuery(document).ready(function(){
        jQuery("#gallery").unitegallery({
        gallery_theme:"tiles",
                tiles_type:"columns",
                tiles_min_columns: 2, //min columns
                tiles_max_columns: 3 //max columns (0 for unlimited)
        });
    });

    jQuery(document).ready(function(){
        jQuery("#singlePageGallery").unitegallery({
        gallery_theme:"tiles",
                tiles_type:"columns",
                tiles_min_columns: 2, //min columns
                tiles_max_columns: 4 //max columns (0 for unlimited)
        });
    });

    $(".socialShare").jsSocials({
        shares: ["email", "twitter", "facebook", "googleplus", "linkedin", "pinterest", "whatsapp"],
        shareIn : "popup"
    });

</script>


<script>
<?php if ($this->uri->uri_string() == '') { ?>

        $(".owl-carousel").owlCarousel({
        loop:true,
                autoplay:true,
                autoplaySpeed:3000,
                nav:true,
                items:1,
                center:true
        });
                $("#calendar").fullCalendar({
        header: {
        left: 'prev,next today',
                center: 'title',
                right: 'month'
        },
                defaultDate: new Date(),
                height: 700,
                displayEventTime: false,
                events: [
    <?php
    $i = 0;
    $totalevents = count($events);
    foreach ($events as $events) {
        $i++;
        ?>
                    {

                    url: '<?php
        echo base_url() . "home/event/view/";
        echo $events->eventid;
        ?>',
                            title: '<?php echo $events->eventtitle; ?>',
                            start: '<?php
        $edate = $events->eventdate;
        echo date("Y-m-d", strtotime(str_replace("/", "-", $edate)));
        ?>'
                    }<?php
        if ($i == $totalevents) {

        } else {
            echo ",";
        }
        ?> <?php } ?>
                ],
                eventClick: function(event) {
                if (event.url) {
                window.open(event.url);
                        return false;
                }
                }
        });
                $(".fancybox").fancybox({
        openEffect	: 'none',
                closeEffect	: 'none'
        });
    <?php foreach ($event as $lastevent): ?>
            $("#countdown_clock").countdown("<?php
        $edate = $lastevent->eventdate;
        echo date("Y-m-d", strtotime(str_replace("/", "-", $edate)));
        ?>", function(event) {
            $(this).html(event.strftime('<span>%D<small>day</small></span><span>%H<small>hour</small></span><span>%M<small>min</small></span><span>%S<small>sec</small></span>'));
            });
    <?php
    endforeach;
}
?>

/**** Main Menu Jquery ****/
$('.navbar.primary ul li.parent-menu').hover(
    function() {
        $('ul.dropdown-menu', this).stop().slideDown(400);
    },
    function() {
        $('ul.dropdown-menu', this).stop().slideUp(400);
    }
);

</script>
</body>
</html>
