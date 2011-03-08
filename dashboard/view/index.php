<h2>Failures</h2>
<p>Based on the server logs, these are the records that appear the most in the failure logs. Actions that are recorded are login (1), register (solving the recaptcha) (2), verifing email (3), and password reset attempts (4).</p>

<?php


print '<h3>IP Addresses</h3>';
print '<table>';
print '<thead><tr><th>IP Address</th><th>Number</th></tr></thead><tbody>';
foreach($failed_ips as $row)
{
	print '<tr><td>'. $row->ip_address. '</td><td>'. $row->count. '</td></tr>';
}
print '</tbody></table>';


print '<h3>domains</h3>';
print '<table>';
print '<thead><tr><th>domains</th><th>Number</th></tr></thead><tbody>';
foreach($failed_domains as $row)
{
	print '<tr><td>'. $row->domain. '</td><td>'. $row->count. '</td></tr>';
}
print '</tbody></table>';


print '<h3>Emails</h3>';
print '<table>';
print '<thead><tr><th>Email</th><th>Number</th></tr></thead><tbody>';
foreach($failed_emails as $row)
{
	print '<tr><td>'. $row->email. '</td><td>'. $row->count. '</td></tr>';
}
print '</tbody></table>';


print '<h3>Actions</h3>';
$actions = array(
	1 => 'login',
	2 => 'register',
	3 => 'verify_email',
	4 => 'password_reset',
);
print '<table>';
print '<thead><tr><th>Action</th><th>Number</th></tr></thead><tbody>';
foreach($failed_actions as $row)
{
	print '<tr><td>'. $actions[$row->action]. '</td><td>'. $row->count. '</td></tr>';
}
print '</tbody></table>';

?>

<h2>System Usage</h2>
<p>Based on the server logs, these are the records that appear the most in the database logs. This tells us which sites are using the most traffic.</p>

<?php
print '<h3>Top Domain Logins</h3>';
print '<table>';
print '<thead><tr><th>Domain</th><th>Number of Logins</th></tr></thead><tbody>';
foreach($top_login_domains as $row)
{
	print '<tr><td>'. $row->domain. ' ('. $row->domain_id. ')</td><td>'. $row->count. '</td></tr>';
}
print '</tbody></table>';


print '<h3>Top User Domains</h3>';
print '<table>';
print '<thead><tr><th>Domain</th><th>Number of Logins</th></tr></thead><tbody>';
foreach($top_user_domains as $row)
{
	print '<tr><td>'. $row->domain. ' ('. $row->domain_id. ')</td><td>'. $row->count. '</td></tr>';
}
print '</tbody></table>';