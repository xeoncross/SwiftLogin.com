<h2>SwiftLogin API</h2>

<p>Adding SwiftLogin to your site is very easy and only requires two steps. There are no signups or API keys to keep track of.</p>

<ol>
	<li>Place a link to <em>https://swiftlogin.com/login</em> on any page.</li>
	<li>Send a HTTP request to our server when the user returns.</li>
</ol>

<p>See an example site at <a href="http://example.swiftlogin.com">http://example.swiftlogin.com</a> and download the <a href="https://github.com/SwiftLogin/Example-SwiftLogin-Site">source code from github</a>.

<h2>Step 1: Link to SwiftLogin</h2>

<p>Place a link to <em>https://swiftlogin.com/login</em> on any of your pages (or send them with a HTTP redirect) along with a URL parameter telling us where to send the user after they login. For example, if your login page is located at <em>http://example.com/login</em>, then you would append that value to the URI using the <em>url</em> GET parameter.</p>

<code>https://swiftlogin.com/login?url=http://example.com/login</code>

<p>The above URL tells us that after the user completes login we should return them to <em>http://example.com/login</em> with a login token. The complete HTML link might look like the following.</p>

<code><?php print h('<a href="https://swiftlogin.com/login?url=http://example.com/login" title="Login with SwiftLogin">Login/Register</a>');?></code>

<h2>Step 2: Verify Login Token</h2>

<p>After the user returns from successfully logging in, they will have a secret key you can use to fetch their account information. Simply pass that key back to our server using a simple HTTP request.</p>

<code><?php
print h('GET https://swiftlogin.com/verify?key=PLACEKEYHERE HTTP/1.1');
?></code>

<p>We will return a JSON encoded response containing the user's email, their timezone offset, a timestamp, and a rating.</p>

<pre>
{
	"email":"user@example.com",
	"timestamp":"1234567890",
	"rating":"2",
	"timezone":"-3"
}
</pre>

If the token provided is not valid, the response will instead return an error. A token may not be reused.

<pre>
{
	"error":"Invalid Request"
}
</pre>


<?php
/*
<h3>Ruby</h3>

<code><?php 
print h("Net::HTTP.get(URI.parse('https://swiftlogin.com/verify?key=?'))"); 
?></code>
*/
?>


<h2>Important Usage Terms</h2>
<p>Displaying a full email address on your site is discouraged as it violates a users privacy and opens 
the door for spam bots to "harvest" the email. Therefore, you are not allowed to publicly display an email
you received from SwiftLogin on your site. You may display the email to other site members as long as it 
obfuscated, displayed in an image, or HTML encoded. If you need to show something then show the local "username" 
(the part before the "@"). These rules are in place to provide a level of harvesting protection.</p>

<p><b>Any site displaying user emails in a way we deem inappropriate may be blocked.</b></p>

<p>Remember, as site owners it is our responsibility to protect our members privacy.</p> 

<p>THIS WEB SITE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
OWNERS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THIS SITE OR THE USE OR OTHER DEALINGS IN
THIS SITE.</p>

<!-- If you must display the email, show the email inside an image - and only to other members. -->