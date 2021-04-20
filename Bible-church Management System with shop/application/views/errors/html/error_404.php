<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php
$ci = new CI_Controller();
$ci =& get_instance();
$ci->load->helper('url');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>404 Page Not Found</title>
<link href='http://fonts.googleapis.com/css?family=Amarante' rel='stylesheet' type='text/css'>
<style type="text/css">

body{
    margin:0;
}

img{
	margin: 5% auto;
	padding: 0;
	float: none;
	width: 35%;
	display: block;
}

h1, h1 a {
    margin: 2% 0;
    padding: 0;
    text-align: center;
    font-size: 2em;
    color: #f7503b;
    font-weight: bold;
}

</style>
</head>
<body>
	<h1><a href="<?php echo base_url(); ?>">Opps! Nothing Found.</a></h1>
    <img src="<?php echo base_url(); ?>assets/assets/images/error.png" alt="404 Page">
    <h1><a href="<?php echo base_url(); ?>">Go To Home</a></h1>
</body>
</html>
