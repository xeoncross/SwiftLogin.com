<h1>Register on a new site</h1>

<!--<p>Click "yes" to register on <b><?php print $domain; ?></b> and share your email with them. -->

<p>We take your privacy very seriously. So before we link your account with <b><?php print $domain; ?></b>
please confirm you wish to register there.</p>

<!-- 
<p>It looks like you have never logged into <b><?php print $domain; ?></b> before.
Would you like to register by sharing your email with them? Either answer will 
returned you to <?php print $domain; ?>.</p>
 -->
 
<br /><br /><br /><br />
<?php //print dump($_POST); ?>

<form method="post" style="float:right">
	<input type="hidden" name="token" value="<?php print session('token'); ?>" />
	<input type="hidden" value="no" name="no" />
	<input type="submit" class="button red" value="No" />
</form>

<form method="post">
	<input type="hidden" name="token" value="<?php print session('token'); ?>" />
	<input type="hidden" value="yes" name="yes" />
	<input type="submit" class="button green" value="Yes" />
</form>
