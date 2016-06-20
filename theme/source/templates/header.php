<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<!--[if lt IE 9]>
	<script src="http://umpeixeforadagua.com/wp-content/themes/peixe/js/html5.js"></script>
	<![endif]-->
	<title><?php if ( is_home() ) { ?><? bloginfo('name'); ?>
	<?php } else {wp_title(''); ?>&nbsp;-&nbsp;<? bloginfo('name'); } ?></title>
	
	<?php wp_head(); ?>
	
	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('stylesheet_url');?>" />

</head>

<body>

<div id="MenuTopBlack">
	<nav class="SimpleNav">
		<div id="Hamburguer_Black"></div>
		<h1 id="LogoBlack"></h1>
		<ul>
			<li><a href="index.html">Home</a></li>
			<li><a href="/about/">About</a></li>
			<li><a href="/blog/">Blog</a></li>
		</ul>
	</nav>
</div>