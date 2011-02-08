<?php
//print dump($keys);
?>
<h2>API Keys</h2>

<p>Below is a list of the API keys you have registered.</p>


<?php
if($keys)
{
	$link = '<a href="?token='.session('token').'&key_id=';
	foreach($keys as $key)
	{
		print '<p><b>'. $key->domain->domain. '</b> ('. $link. $key->id. '">recreate key</a>)<br/>'
			. $key->key. '</p><br />';
			//. '<input type="text" style="padding: .4em; display:block; margin: 0 0 2em 0; width: 100%;" value="'.h($key->key). '">';
	}
}
else
{
	print '<div class="message">no keys yet</div>';
}
?>

<a class="button white" href="/api/create">Create New Key</a>