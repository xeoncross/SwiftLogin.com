<form action="<?php print current_url(); ?>" method="post" class="formstyle">

	<?php print validation_errors(); ?>

	<h1>Edit Reply</h1>

	<label for="text"><b>Reply</b><span class="help"><a href="#">Topic Rules</a></span></label>
	<textarea cols="40" rows="10" name="text" id="text"><?php print $reply->text; ?></textarea>

	<input type="hidden" value="<?php print session('token'); ?>" name="token" />

	<div class="grid_4 alpha">
	<input type="submit" name="submit" value="Submit" class="green" />
	</div>

</form>