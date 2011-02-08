<div id="thread">

	<div class="topic <?php if($topic->status == FORUM_DISABLED) print 'disabled'; ?>">

		<h2><?php print $topic->title; ?><?php if($topic->status == FORUM_DISABLED) print ' (Disabled!)'; ?></h2>
		
		<div class="text"><?php print $topic->text; ?></div>
		
		<?php if ( $topic->modified )
		{
			print '<p style="color: #ccc;"><i>Last edited: '. Time::show($topic->modified). '</i></p>';
		}
		?>
		
		<div class="meta">
			
			<?php if($topic->user_id == session('user_id') OR Forum_User::$is_admin) { ?>
				<div class="action_links">
					<a href="<?php print site_url('topic/update/'. $topic->id); ?>">Edit</a>
					<?php if(Forum_User::$is_admin) { ?>
					- <a class="disable" href="<?php print site_url('topic/disable/'. $topic->id. '/'. base64_url_encode(url())); ?>">Disable</a>
					<?php } ?>
				</div>
			<?php }?>
			
			<div>Posted by <a href="<?php print $topic->user->website(); ?>" target="_blank"><?php print $topic->user->username(); ?></a> 
			on <span class="date"><?php print Time::show($topic->created); ?></span></div>
		
			<?php //print html::gravatar($topic->user->email, 40, $topic->user->username()); ?>
			
			<?php
			/*
			<div class="action_links">
				<?php if( $user_can['admin'] OR ($user_can['edit_topic'] && $topic->user_id == $this->user_id) ) { ?>
					<a class="edit" href="<?php print site_url('forum/create_topic/'. $topic->forum_id. '/'. $topic->id); ?>">Edit Topic</a>
				<?php } ?>
	
				<?php if( $user_can['admin'] ) { ?>
	
					<?php if ($topic->status == FORUM_ACTIVE ) { ?>
						<a class="disable" href="<?php print site_url('forum/disable/topic/'. $topic->id. '/'. $safe_uri); ?>">Disable</a>
						<a class="sticky" href="<?php print site_url('forum/sticky/topic/'. $topic->id. '/'. $safe_uri); ?>">Sticky</a>
	
					<?php } elseif ( $topic->status == FORUM_DISABLED ) { ?>
						<a class="enable" href="<?php print site_url('forum/enable/topic/'. $topic->id. '/'. $safe_uri); ?>">Enable</a>
						<a class="sticky" href="<?php print site_url('forum/sticky/topic/'. $topic->id. '/'. $safe_uri); ?>">Sticky</a>
	
					<?php } elseif ( $topic->status == FORUM_STICKY ) { ?>
						<a class="enable" href="<?php print site_url('forum/enable/topic/'. $topic->id. '/'. $safe_uri); ?>">Enable</a>
						<a class="disable" href="<?php print site_url('forum/disable/topic/'. $topic->id. '/'. $safe_uri); ?>">Disable</a>
	
					<?php } ?>
				<?php } ?>
	
				<?php if( $user_can['report'] ) { ?>
					<a class="report" href="<?php print site_url('forum/report/topic/'. $topic->id. '/'. $safe_uri); ?>">Report Spam</a>
				<?php } ?>
			</div>
			*/ ?>
		</div>
	</div>

	<?php
	//Now render replies (if any)
	if($replies) {
		foreach($replies as $reply) {
	?>
	<div class="reply <?php if($reply->status == FORUM_DISABLED) print 'disabled'; ?>">

		<div class="text">
			<?php print $reply->text; ?>
		</div>
		
		<?php if ( $reply->modified )
		{
			print '<p style="color: #ccc;"><i>Last edited: '. Time::show($reply->modified). '</i></p>';
		}
		?>
		
		<div class="meta">
			
			<?php //print html::gravatar($reply->user->email, 40, $reply->user->username()); ?>
			
			<?php if($reply->user_id == session('user_id') OR Forum_User::$is_admin) { ?>
				<div class="action_links">
					<a href="<?php print site_url('reply/update/'. $reply->id); ?>">Edit</a> -
					<a class="disable" href="<?php print site_url('reply/disable/'. $reply->id. '/'. base64_url_encode(url())); ?>">Disable</a>
				</div>
			<?php }?>
			
			<?php
			/*
			<div class="action_links">
				<?php if( $user_can['admin'] OR ($user_can['edit_topic'] && $reply->user_id == $this->user_id) ) { ?>
					<a class="edit" href="<?php print site_url('forum/create_topic/'. $reply->forum_id. '/'. $reply->id); ?>">Edit Topic</a>
				<?php } ?>
	
				<?php if( $user_can['admin'] ) { ?>
	
					<?php if ($reply->status == FORUM_ACTIVE ) { ?>
						<a class="disable" href="<?php print site_url('forum/disable/topic/'. $reply->id. '/'. $safe_uri); ?>">Disable</a>
						<a class="sticky" href="<?php print site_url('forum/sticky/topic/'. $reply->id. '/'. $safe_uri); ?>">Sticky</a>
	
					<?php } elseif ( $reply->status == FORUM_DISABLED ) { ?>
						<a class="enable" href="<?php print site_url('forum/enable/topic/'. $reply->id. '/'. $safe_uri); ?>">Enable</a>
						<a class="sticky" href="<?php print site_url('forum/sticky/topic/'. $reply->id. '/'. $safe_uri); ?>">Sticky</a>
	
					<?php } elseif ( $reply->status == FORUM_STICKY ) { ?>
						<a class="enable" href="<?php print site_url('forum/enable/topic/'. $reply->id. '/'. $safe_uri); ?>">Enable</a>
						<a class="disable" href="<?php print site_url('forum/disable/topic/'. $reply->id. '/'. $safe_uri); ?>">Disable</a>
	
					<?php } ?>
				<?php } ?>
	
				<?php if( $user_can['report'] ) { ?>
					<a class="report" href="<?php print site_url('forum/report/topic/'. $reply->id. '/'. $safe_uri); ?>">Report Spam</a>
				<?php } ?>
			</div>
			*/ ?>
		
		<div>Posted by <a href="<?php print $reply->user->website(); ?>" target="_blank"><?php print $reply->user->username(); ?></a> 
		on <span class="date"><?php print Time::show($reply->created); ?></span></div>
		
		</div>
	</div>
<?php
	}

//Perhaps there are replies - but we don't show them to guests ;)
} elseif( FALSE ) { ?>
	<div class="reply">

		<div class="grid_9 prefix_3">
		<div class="text">
			<h2>Register First</h2>
			<p>Please register so that you will have full access to all topic replies.</p>
		</div>
		</div>

	</div>
<?php } ?>





<?php if(session('user_id')) { //IF the user can reply ?>
<form id="reply_form" action="<?php print site_url('reply/create/'.$topic->id.'/'); ?>" method="post" class="formstyle">

	<h2>Post a Reply</h2>
	<textarea cols="40" rows="10" name="text" id="text"></textarea>
	<input type="hidden" value="<?php print session('token'); ?>" name="token" />
	<input type="submit" value="Submit" name="submit" class="submit" />
	
	<?php
	/*
	<div class="grid_5">
	<h2>Style Guide</h2>

	<p>&lt;b&gt;<b>for bold</b>&lt;/b&gt;<br />
	&lt;strike&gt;<strike>to strike text</strike>&lt;/strike&gt;<br />
	URL's (i.e. <a href="#">1jn2.com</a>) turn into links automatically. </p>

	<blockquote>&lt;blockquote&gt;For quotes&lt;/blockquote&gt;</blockquote>

	<code>&lt;code&gt;
<span class="code_html"><span class="code_comment">//A comment</span>
<span class="code_default">print&nbsp;</span><span class="code_string">'hello&nbsp;world'</span><span class="code_keyword">;</span>
</span>&lt;/code&gt;</code>
	</div>
	*/
	?>
</form>

<?php } ?>
</div>
