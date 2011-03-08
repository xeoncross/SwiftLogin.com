<div id="admin">

<script type="text/javascript">
//Select / Deselect all checkboxes
function CheckAll(fmobj) {
	fmobj = document.getElementById(fmobj);
	for (var i=0;i<fmobj.elements.length;i++) {
		var e = fmobj.elements[i];
		if ((e.name != 'allbox') && (e.type=='checkbox') && (!e.disabled)) {
			e.checked = fmobj.allbox.checked;
		}
	}
}
</script>

<div class="box">
	<form method="post" id="admin_search">
		Search for <input name="term" value="<?php print h(post('term',$term)); ?>" /> in
		<select name="column">
			<?php
			foreach($columns as $value)
			{
				print '<option value="'. $value. '"'. ($column == $value ? ' selected="selected"' : '').'>'. $value. '</option>'; 
			}
			?>
		</select>
		<input type="submit" value="Go" />
	</form>
</div>

<form id="admin_form" action="<?php print $config['process_url']. '/'. base64_url_encode(url()); ?>" method="post">
<input type="hidden" name="token" value="<?php print session('token'); ?>" />
<table>
	<thead>
		<tr>
			<th>
				<input name="allbox" type="checkbox" title="Check All" onclick="CheckAll('admin_form');" />
			</th>
			<?php
			foreach($columns as $key => $value)
			{
				if(!is_int($key)) $value = $key;
				
				// Get the page number
				$url = $config['admin_url']. '/'. $page;

				//If this is the current column
				if($value == $field)
				{
					// Reverse the sort
					$sort = $sort == 'desc' ? 'asc' : 'desc';
					$class = ($sort == 'asc' ? 'down' : 'up');
				}
				else
				{
					$class = 'down';
				}
				

				print '<th><a href="'. $url. '/'. $value. '/'. $sort. ($column ? "/$column/". base64_url_encode($term) : ''). '" class="sort_by '. $class . '">';
				print ucwords(str_replace('_', ' ', $value)). '</a></th>';
			}
			?>
		</tr>
	</thead>

	<tbody>
	<?php
	if(!empty($rows))
	{

		//Print each of the result rows
		foreach($rows as $row)
		{
			print '<tr>';
			print '<td style="min-width:50px"><input type="checkbox" name="ids[]" value="'. $row->id. '"/>';
			print '<a href="'. $config['update_url']. '/'. $row->id. '" class="edit">Edit</a></td>';
			
			foreach($columns as $key => $value) print '<td>'. $row->$value. '</td>';
			
			print '</tr>';
		}
	}
	?>
	</tbody>

	<tfoot>
		<tr>
			<td colspan="<?php print count($columns) + 1; ?>">
				<?php if( $config['actions']) { ?>
				<select name="action">
					<option>with selected...</option>
					<?php foreach($config['actions'] as $name => $action)
					{
						$option = $action ? $action['name'] : $name;
						print '<option value="'. $name. '">'. $option. '</option>';
					}
					?>
				</select>

				<input type="submit" value="Apply" />
				<?php } ?>
			</td>
		</tr>
	</tfoot>

</table>
</form>

</div>
