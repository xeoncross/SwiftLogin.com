<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
	<title>EmailLogin.net - A universal user account for every site</title>
	
	<link rel="stylesheet" media="all" href="<?php print theme_url(); ?>css/my.css"/>
	<link rel="stylesheet" media="all" href="<?php print theme_url(); ?>css/form.css"/>
	<link rel="stylesheet" media="all" href="<?php print module_url('system.css'); ?>"/>
	
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	
	<script type="text/javascript">
		$=function(e){return e.style?e:document.getElementById(e)}
		var kb={
		on:function(e,t,f,r){if(e.attachEvent?(r?e.detachEvent('on'+t,e[t+f]):1):(r?e.removeEventListener(t,f,0):e.addEventListener(t,f,0))){e['e'+t+f]=f;e[t+f]=function(){e['e'+t+f](window.event)};e.attachEvent('on'+t,e[t+f])}},
		ready:function(f){"\v"=="v"?setTimeout(f,0):kb.on(document,'DOMContentLoaded',f)},
		ajax:function(u,f,d,x){x=new(window.ActiveXObject||XMLHttpRequest)('Microsoft.XMLHTTP');x.open(d?'POST':'GET',u,1);x.setRequestHeader('X-Requested-With','XMLHttpRequest');x.setRequestHeader('Content-type','application/x-www-form-urlencoded');x.onreadystatechange=function(){x.readyState>3&&f&&f(x.responseText,x)};x.send(d)},
		}
	</script>
	
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
	
	<div id="main">
		
		<?php
		/*
		if(isset($error))
		{
			if($error === 'incorrect-captcha-sol')
			{
				$error = 'Sorry, you typed an invalid image code, please try again.';
			}
			
			print '<div class="error_box">'. $error. '</div>';
		}
		?>
		<?php
		if(isset($message))
		{
			print '<div class="message_box">'. $message. '</div>';
		}
		?>
		
		<?php print message();?>
	
		<?php if( ! empty($sidebar)) { ?>
			
			<div id="content">
				<?php print $content; ?>
				<?php if(isset($pagination)) print $pagination; ?>
				<?php if(isset($debug)) print '<div id="debug">'. $debug. '</div>'; ?>
			</div>
			
			<div id="sidebar">
				<?php print $sidebar; ?>
			</div>
			
		<?php } else { // Else they want to do the content layout themselves... ?>
		*/
		?>
			<div id="page">
				<?php print $content; ?>
				<?php if(isset($pagination)) print $pagination; ?>
				<?php if(isset($debug)) //print '<div id="debug">'. $debug. '</div>'; ?>
			</div>
			
		<?php //} ?>
		
	</div>
	
	<div id="footer">
		<div class="info" style="float: right;">Copyright 2010 &copy; emaillogin.net - <a href="/api">developers</a></div>
		
		<p class="info">
		<?php if(session('user_id')) { ?>
		<a href="/logout">logout</a> - 
		<a href="/key">keys</a> - 
		<a href="/change_password">change password</a>
		<?php } elseif(url(0) !== 'login') { ?>
			<a href="/login">login</a>
		<?php } ?>
		<a href="/about">about</a>
		</p>
	</div>
	
</div>
<?php
if( ! empty($footer))
{
	print $footer;
}
?>
</body>
</html>