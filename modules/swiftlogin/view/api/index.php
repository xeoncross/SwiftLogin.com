<h2>SwiftLogin API</h2>

<p>Adding SwiftLogin to your site is very easy and only requires two steps. There are no signups or API keys to keep track of.</p>

<ol>
	<li>Place a link to <em>https://swiftlogin.com/login</em> on any page.</li>
	<li>Send a HTTP request to our server when the user returns.</li>
</ol>

<h2>Step 1: Link to SwiftLogin</h2>

<p>Place a link to <em>https://swiftlogin.com/login</em> on any of your pages (or send them with a HTTP redirect) along with a URL parameter telling us where to send the user after they login. For example, if your login page is located at <em>http://example.com/login</em>, then you would append that value to the URI using the <em>url</em> GET parameter.</p>

<code>https://swiftlogin.com/login?url=http://example.com/login</code>

<p>The above URL tells us that after the user completes login we should return them to <em>http://example.com/login</em> with a login token. The complete HTML link might look like the following.</p>

<code><?php print h('<a href="https://swiftlogin.com/login?url=http://example.com/login" title="Login with SwiftLogin">Login/Register</a>');?></code>

<h2>Step 2: Verify Login Token</h2>

<p>After the user returns from successfully logging in, they will have a secret key you can use to fetch their account information. Simply pass that key back to our server using a simple HTTP request.</p>

<code><?php
print h('GET https://swiftlogin.com/verify?key=? HTTP/1.1');
?></code>

<p>We will return a JSON encoded response containing the user's email, a timestamp, and a SwiftLogin rating</p>

<h3>Ruby</h3>

<code><?php 
print h("Net::HTTP.get(URI.parse('https://swiftlogin.com/verify?key=?'))"); 
?></code>

<h2>Important Usage Restriction</h2>
<p>Displaying a full email address on your site is discouraged as it violates a users privacy and opens 
the door for spam bots to "harvest" the email. Therefore, you are not allowed to display an email you recived from SwiftLogin
on your site. This includes even emails that are HTML encoded. Any site caught displaying user emails may be blocked.</p>

<p>Remember, as site owners it's our responsibility to protect our members privacy. 
If you must display the email, show the email inside an image - and only to other members.</p>