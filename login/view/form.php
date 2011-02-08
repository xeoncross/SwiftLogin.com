<h1>Login / Register</h1>

<div class="login_help">
<b>New Users:</b> Enter your email and select a password.<br/>
<b>Existing Users:</b> Enter your email and password.
</div>

<?php print message();?>

<form method="post" id="login" name="login">
	
		<label for="email">
			<!-- <span><input type="checkbox" name="remember_me" <?php if(post('remember_me')) { print 'checked="yes"'; } ?>/> Stay logged in?</span> -->
			Email
		</label>
		<input tabindex="1" type="email" name="email" id="email" value="<?php print h(post('email'));?>" class="text shadow" />
		
		<?php
		/*
		foreach($inputs as $input)
		{
			print '<input type="text" name="'. $input. '" id="'. $input. '" value="'. h(post('email')). '" class="email text shadow" />'. "\n";
		}
		*/
		?>
		
		<label for="email"><span><a href="/account/recover">Forgot your Password?</a></span>Very Complex Password</label>
		<input tabindex="2" type="password" name="password" value="" class="text shadow" /><br />
		
		<?php
		/*
		if(FALSE && $captcha)
		{
			print '<label for="recaptcha_challenge_field">3. Anti-spam Check</label>';
			print recaptcha_html(config('public_key', 'recaptcha'), (isset($errors['captcha']) ? $errors['captcha'] : NULL), 'white'). '<br />'; 
		}
		*/
		?>
		
		<input type="hidden" name="token" id="token" value="<?php print session('token'); ?>" />
		
		<a id="what_is_this">(What is this?)</a>
		
		<input tabindex="3" type="submit" class="button white shadow" value="Submit" />
</form>

<p class="meta" id="meta">
<br /><br />Creating an account on swiftlogin.com will allow you to instantly 
access many sites without the need to register over and over for each one. <br /><br />
<!-- We only share your email with sites you log on to so you don't have to waste time registering,
or filling out forms. -->
This process works by sharing your email with each site you login to so you don't have to fill out another form.
<br /><br />

After login, you will be redirected back to <b><?php print session('callback_domain'); ?></b>
</p>

<script type="text/javascript">
document.login.email.focus(); // Select email field on load
document.getElementById('meta').style.display = 'none';
document.getElementById('what_is_this').onclick=function(){document.getElementById('meta').style.display='';return false}
</script>

<?php
/*
<script>
kb.ready(function(){
	kb.ajax('/login/ajax_input',function(response){if(response)$(response).style.display='block'},encodeURIComponent('token')+'='+encodeURIComponent($('token').value));
});
</script>
*/
?>