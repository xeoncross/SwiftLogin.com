<div class="forum">
<table id="latest_topics">
	<tr>
		<th colspan="2">Recent Topics</td>
	</tr>
	
	<?php foreach($topics as $topic) { 
	
		//print dump($topic->to_array());
		//print dump($topic->user);
		//continue;
		?>
	
		<tr class="topic">
			<td><a href="<?php print site_url(). 'topic/view/'. $topic->id; ?>">
			<?php print $topic->title; ?></a>
			<div class="meta">
			<?php //print Time::human_friendly($topic->created); ?>
			<?php print Time::show($topic->created); ?>
			</div></td>
		
			<td>
				<?php if($topic->user) { ?>
				<?php if(config('use_gravatars', 'forum')) {?>
					<?php print html::gravatar($topic->user->email, 40, $topic->user->username); ?>
				<?php } else { ?>
					<?php print $topic->user->username; ?>
				<?php } ?>
				<?php } else { print 'unknown'; } ?>
			</td>
		
		</tr>
	
	<?php } ?>
</table>
</div>