<?php
//print dump($keys);
$email = explode('@',session('email'));
$username = $email[0];
$domain = $email[1];
if(substr_count($username, '.') == 2)
{
	$username = implode(' ', explode('.', $username));
}
$username = ucwords($username);
?>
<h3>Welcome, <?php print $username; ?></h3>

<?php print message(); ?>

<div class="profile_box">

<img src="https://secure.gravatar.com/avatar/<?php print md5(session('email'));?>?s=80&d=mm" alt="Gravatar.com Image" style="margin: 0 2em 0 0; float: left;" />

<?php print session('email'); ?><br />
Website: <a href="http://<?php print $domain; ?>" target="_blank"><?php print $domain; ?></a><br />
(<a href="http://gravatar.com/" target="_blank">change image on gravatar.com</a>)
<br style="clear:both;" />
</div>

<form method="post">

	<label>Change Password?<span class="help">leave blank to keep current password</span></label>
	<input type="password" name="new_password" class="text" autocomplete="off" />
	
	<input type="hidden" name="token" value="<?php print session('token'); ?>" />
	<input type="submit" value="Change" class="button white" />
	
</form>
