<table id="forum_list">

<tr>
	<th>Forum Name</th>
	<th class="meta">Topics</th>
	<th class="meta">Replies</th>
</tr>

<?php
if($categories)
{
	//print dump($categories);

	foreach($categories as $category)
	{
		print '<tr class="category">';
		print '<td colspan="3"><b>'. $category->name. '</b></td>';
		print '</tr>';
		
		// Fetch all the forums
		if($forums = $category->forums())
		{
			foreach($forums as $forum)
			{
				print '<tr class="forum">';
				print '<td><a href="/forum/view/'. $forum->id. '">'. $forum->name. '</a>';
				print '<div>'. $forum->description. '</div></td>';
				print '<td class="meta">'.$forum->count_topics().'</td>';
				print '<td class="meta">'.$forum->count_replies().'</td>';
				print '</tr>';
			}
		}
	}
}
else
{
	print '<tr><td colspan="3">No Forums</td></tr>';
}

?>
</table>