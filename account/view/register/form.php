<h1>Registration</h1>

<div class="login_help">
To help reduce spam and protect your account, please type the two words below.
</div>

<?php print message();?>

<form method="post" id="register" name="register">

		<?php print $recaptcha; ?>
		<br />
		<input type="hidden" name="token" id="token" value="<?php print session('token'); ?>" />
		<input type="hidden" name="timezone" id="timezone" value="0" />
		
		<input type="submit" class="button white shadow" value="Submit" />
</form>

<script type="text/javascript">
document.register.recaptcha_response_field.focus(); // Select field on load
document.getElementById('timezone').value=new Date().getTimezoneOffset()/60;
</script>