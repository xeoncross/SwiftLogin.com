<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
	<title>MicroMVC PHP Framework</title>
	<meta name="viewport" content="initial-scale=1.0, width=device-width, maximum-scale=1.0" />
	
	<link rel="stylesheet" media="all" href="/swiftlogintheme/view/css/base.css"/>
	<link rel="stylesheet" media="all" href="/swiftlogintheme/view/css/admin.css"/>
	
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<?php
	//Print all CSS files
	if( ! empty($css)) foreach($css as $file) print '<link rel="stylesheet" media="all" href="'. site_url($file). '" />';
	
	//Print all JS files
	if( ! empty($javascript)) foreach($javascript as $file) print '<script type="text/javascript" src="'.site_url($file). '"></script>';
	
	//Print any other header data
	if( ! empty($head_data)) print $head_data;
	?>

</head>
<body>
<div id="container">
<div id="sidebar">
	<h2><?php print substr(DOMAIN,7); ?></h2>
	<ul>
		<li><a href="/dashboard">Dashboard</a></li>
		<li><a href="/forum/admin">Forum</a>
			<ul id="subposts" >
				<li><a href="/topic/admin">Topic</a></li>
				<li><a href="/reply/admin">Reply</a></li>
			</ul>
		</li>
		<li><a href="/account/admin">Users</a></li>
	</ul>
</div>
	
<div id="main">
	
	<div id="header">
		<ul class="horizontal_menu">
			<li><a href="<?php print site_url(); ?>">Back to Site</a></li>
		</ul>
	</div>

	<div id="content">
	
		<?php print message();?>
		<?php print $content; ?>
		
		<?php if(isset($pagination)) print '<div class="box">'. $pagination. '</div>';?>
		
	</div>
	
	<div id="footer">
	
		<ul class="horizontal_menu">
			<li class="right">Page rendered in <?php print round((microtime(true) - START_TIME), 4); ?> seconds
			taking <?php print round((memory_get_usage() - START_MEMORY_USAGE) / 1024, 2); ?> KB
			(<?php print (memory_get_usage() - START_MEMORY_USAGE); ?> Bytes)
			</li>
			<li>Powered By <a href="http://micromvc.com">MicroMVC</a></li>
		</ul>
		
	</div>
	
</div>

</div>
<?php if( ! empty($footer)) print $footer; //JS snippets and such ?>
</body>
</html>