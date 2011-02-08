<h1 id="logo"><a href="/">SwiftLogin</a><span>Email Login System</span></h1>

<ul class="nav">
	<?php
	$links = array(
		'' => 'Home',
		'api' => 'Developer API',
		'forum' => 'Support',
	);
	
	if(session('user_id'))
	{
		$links['account'] = 'Account';
		$links['account/logout'] = 'Logout';
	}
	else
	{
		$links['login?url='.rawurldecode(DOMAIN.'/'.url())] = 'Login';
	}
	
	foreach($links as $url => $link)
	{
		print '<li><a href="/'. $url. '"'. ($url == url(0) ? ' class="active"' : ''). '>'. $link. '</a></li>';
	}
	?>
</ul>

<!-- 
<p>Duis accumsan pretium pharetra. Integer eget lorem 
a purus rhoncus tempor nec quis tellus. Duis interdum semper enim et blandit.</p>
-->

<?php if(session('user_id')) { ?>
<h3>
Hey There!
</h3>
<p><?php print session('email'); ?><br>
<a href="http://www.gravatar.com" class="gravatar" target="_blank">
	<img src="http://www.gravatar.com/avatar/<?php print md5(session('email')); ?>?s=40" alt="Change Gravatar" />
</a>
</p>
<?php } else { ?>

<h3>About</h3>
<p>SwiftLogin is a free API for allowing users to login to sites with a single click using their email address.</p>

<?php } ?>