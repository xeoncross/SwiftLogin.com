<form action="<?php print current_url(); ?>" method="post" class="formstyle">

	<?php print validation_errors(); ?>

	<h1>Reply to <a href="<?php print site_url('topic/view/'. $topic->id); ?>">
	<?php print $topic->title; ?></a></h1>

	<label for="text"><b>Reply</b><span class="help"><a href="#">Topic Rules</a></span></label>
	<textarea cols="40" rows="10" name="text" id="text"><?php print post('text'); ?></textarea>

	<input type="hidden" value="<?php print session('token'); ?>" name="token" />

	<div class="grid_4 alpha">
	<input type="submit" name="submit" value="Submit" class="green" />
	</div>

</form>