<?php
/*
|--------------------------------------------------------------------------
| User Role Levels
|--------------------------------------------------------------------------
|
| Users must be at least *ROLE VALUE* in order to perform
| the following tasks. You can set any of the following
| config values to FALSE to disable role checking. However
| if you only want a certain role (and higher) to perform
| a function - please specify it here. You can also pass
| multiple roles as an array.
|
*/

$config['category_table'] = 'forum_categories';
$config['forum_table']	= 'forum_forums';
$config['topic_table']	= 'forum_test_topics';
$config['reply_table']	= 'forum_test_replies';
$config['user_table']	= 'forum_test_users'; //auth_users';


/*
|--------------------------------------------------------------------------
| User Role Levels
|--------------------------------------------------------------------------
|
| Users must be at least *ROLE VALUE* in order to perform
| the following tasks. You can set any of the following
| config values to FALSE to disable role checking. However
| if you only want a certain role (and higher) to perform
| a function - please specify it here. You can also pass
| multiple roles as an array.
|
*/

// Minimum role to browse the forums (For Private Forums)
$config['browse_role'] = FALSE;

// Minimum role to create/edit own replies
$config['reply_role'] = 'user';

// Minimum role to create/edit own topics
$config['topic_role'] = 'user';

// Minimum role to edit/delete other users topics/replies (all permissions)
$config['admin_role'] = 'admin';

/*
// Role to browse the forums
$config['roles']['browse']		= FALSE;
// Role to browse a given user's topics/replies
$config['roles']['browse_user']	= FALSE;
// Role to report spam topics and replies
$config['roles']['report']		= 'user';

//Role to create topics
$config['roles']['create_topic']	= 'user';
//Role to edit own topics
$config['roles']['edit_topic']	= 'user';

//Role to view replies (experts-exchange styled forum)
$config['roles']['view_replies']	= FALSE;
//Role to create a reply
$config['roles']['create_reply']	= 'user';
//Role to edit own replies
$config['roles']['edit_reply']	= 'user';
*/


/*
|--------------------------------------------------------------------------
| Moderator User Role
|--------------------------------------------------------------------------
|
| Users of this role level will be able to do all permissions
| above to their own topics/replies as well as to ALL others!
| This user can "moderate" the whole forum.
|
| Note that users with the role 'admin' can at ALL TIMES do
| EVERYTHING. This is just to give other roles the chance to
| help manage the forum.
|
| Moderators can:
| Disable/Enable Topics
| Disable/Enable Replies
| Create/Edit Topics
| Create/Edit Replies
| Create/Edit/Delete Forums
|
*
*
//Role to moderate ALL user topics/replies and reported spam
$config['roles']['admin']	= 'moderator';
*/

/*
|--------------------------------------------------------------------------
| Pagination Options (Number of results Per-Page)
|--------------------------------------------------------------------------
|
| The following options determine how many items/rows are shown
| on each page (and in each result).
|
*/

//How many topics should we show?
$config['topic_pagination']	= 8;
//How many replies should we show?
$config['reply_pagination']	= 8;
//Number of latest topics to show? (FALSE to disable)
$config['lastest_topics'] = 8;



/*
|--------------------------------------------------------------------------
| Options that can slow down/speed up the forum
|--------------------------------------------------------------------------
|
| If you find that that you would like to also include
| the number of topics / replies you can enable these and
| extra DB queries will be run to count the number of rows.
|
| Setting these values to FALSE will save a number of DB
| queries and help to speed up the site - but you won't
| be know how many reponses there have been to a topic or
| in a forum.
|
*/

//Should we also count the topics in this forum?
$config['forum_count_topics'] = TRUE;

//Should we also count the replies in this forum?
$config['forum_count_replies'] = TRUE;

//Should we also count the replies in this topic?
$config['topic_count_replies'] = TRUE;



/*
|--------------------------------------------------------------------------
| Teasers
|--------------------------------------------------------------------------
|
| When viewing recent topics and replies it is nice to be able to see a
| little of the content before you click through. This is especially
| helpful when moderating topics and replies. The following values will
| be included in each topic or reply object but it is up to you to use
| them in the theme as you see fit. By default, only the recent/disabled
| replies view makes use of these values.
|
*/

//Number of characters in reply teasers
$config['reply_teaser'] = 150;

//Number of characters in topic teasers
$config['topic_teaser'] = 60;


/*
|--------------------------------------------------------------------------
| Extra Options
|--------------------------------------------------------------------------
|
| These are options that control extra functions within the forum
| system. Most important is the remove_after setting that will auto
| remove disabled topics/replies after [number] seconds. The default
| is two days, which should give the author plenty of time to complain
| and the moderators plenty of time to review the decision.
|
*/

//Show gravatars?
$config['use_gravatars']	= TRUE;

//Should forums be seporated by categories?
$config['use_categories'] = FALSE;

//Number of spam reports before a topic is disabled
$config['reports_to_disable_topic'] = 5;

//Number of spam reports before a reply is disabled
$config['reports_to_disable_reply'] = 3;

//Time before disabled topics/replies should be deleted
$config['remove_after'] = 60 * 60 * 24 * 7; //one week

//The name of the username column when showing a users name
$config['username_column'] = 'username';

//The name of the email column (if using gravatars)
$config['email_column'] = 'email';

//Default status of all new topics
//$config['default_topic_status'] = FORUM_ACTIVE;

//Default status of all new replies
//$config['default_reply_status'] = FORUM_ACTIVE;

// Number of seconds a user must wait to post a new topic
//$config['time_to_create_topic'] = 120;

// Number of seconds a user must wait to post a new reply
//$config['time_to_create_reply'] = 30;

// Number of seconds a user must wait to post again (does not effect edits)
$config['wait_time'] = 120;

// Max length of forum topics and replies (actual length may vary after parsing)
$config['max_text_length'] = 20000;

// Min length of forum topics and replies (helps stop dumb posts)
$config['min_text_length'] = 60;

return $config;
