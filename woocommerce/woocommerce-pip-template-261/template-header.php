<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title><?php _e('Print order details', 'woocommerce-pip'); ?></title>
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.2/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-y3tfxAZXuh4HwSYylfB+J125MxIs6mR5FOHamPBG064zB+AFeWH94NdvaCBm8qnd" crossorigin="anonymous">
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
	<link href="<?php echo woocommerce_pip_template('uri', 'template-body.php'); ?>css/woocommerce-pip-print.css?v=1.0.5" rel=" stylesheet" type="text/css" media="print" />
	<link href="<?php echo woocommerce_pip_template('uri', 'template-body.php'); ?>css/woocommerce-pip.css?v=1.0.5" rel=" stylesheet" type="text/css" media="screen,print" />
</head>
<body <?php if ($client != true) echo woocommerce_pip_preview(); ?>>
