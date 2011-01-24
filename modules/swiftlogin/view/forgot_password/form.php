<h2>Forgot You Password?</h2>

<p>Type your email and we will send you a login link you can use to change your password.</p>

<?php print message();?>

<form method="post">
	<label for="email"><span></span>Email</label>
	<input type="text" name="email" value="<?php print h(post('email')); ?>" class="text" />
	
	<?php print $recaptcha; ?>
	
	<br />
	<input type="hidden" name="token" value="<?php print session('token'); ?>" />
	<input type="submit" class="submit button white" value="Submit" />
</form>