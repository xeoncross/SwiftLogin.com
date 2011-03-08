<table id="topic_list">

<tr>
	<th>Topic </th>
	<th class="meta">Replies</th>
	<th class="meta"><a href="http://www.gravatar.com/" target="_blank">User</a></th>
	<th class="meta">Last Activity</th>
</tr>

<?php
if($topics)
{
	$evenodd = 0;
	foreach($topics as $topic)
	{
		//Even/odd rows
		$evenodd = (1 - $evenodd);
	
		print '<tr class="row_'. $evenodd.'">';
		
		print '<td><a href="/topic/view/'. $topic->id. '/'. String::sanitize_url($topic->title). '">'. $topic->title. '</a>';
		print '<div class="teaser">'. substr(strip_tags($topic->text), 0, 70). '...</div></td>';
		
		print '<td class="meta">'.$topic->count_replies().'</td>';
		print '<td class="meta">'. ($topic->user ? html::gravatar($topic->user->email, 25) : ''). '</td>';
		print '<td class="meta">'.Time::show($topic->last_activity).'</td>';
		
		print '</tr>';
	}
}
else
{
	print '<tr><td colspan="4">No Topics</td></tr>';
}
?>
</table>