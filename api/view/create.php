<h2>Create New API Key</h2>

<?php print message(); ?>

<p>Before we can give you an API key we need to verify that you have permission to make
requests on behalf of a site. To do so we need you to create a blank HTML file in the
document root of the domain you wish to use. Doing so will prove you
you have administrator access.</p>

<p>1) Create a page named <b>swiftlogin<?php print session('api_token').'.html'; ?></b></p>


<!--
<p>For example, if your site was http://example.com then you would 
enter "http://example.com" in the form and create a blank page 
named "http://example.com/<?php print 'swiftlogin_'.session('api_token').'.html'; ?>"
-->

<p>2) Enter the full domain URL (http://example.com).</p>

<form method="post" action="/api/create" class="formstyle">
	
	<label for="domain"><span>do not include an ending "/"</span>Website</label>
	<input type="text" name="domain" value="<?php print post('domain') ? h(post('domain')) : 'http://'; ?>" class="text" />
	
	<p>As soon as you click submit we will make a request to your website to verify the page exists.</p>

	<input type="hidden" name="api_token" value="<?php print session('api_token'); ?>" />
	<input type="submit" class="button white" value="Submit" />
	
</form>