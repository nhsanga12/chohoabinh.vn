<?php

// Include the YOS library.
require 'lib/Yahoo.inc';
include 'db_config.php';

session_start();

define('OAUTH_CONSUMER_KEY', 'dj0yJmk9cTFBREhIUjhBbkFDJmQ9WVdrOWVWQXlaVE5QTlRZbWNHbzlPVEEyTURZd01qWXkmcz1jb25zdW1lcnNlY3JldCZ4PWRj'); // Place Yoru Consumer Key here
define('OAUTH_CONSUMER_SECRET', 'd152ea3c43ef78b3376f8c96dc183c93c4d0a4f2'); // Place your Consumer Secret
define('OAUTH_APP_ID', 'yP2e3O56'); // Place Your App ID here

if (array_key_exists("login", $_GET)) {
    $session = YahooSession::requireSession(OAUTH_CONSUMER_KEY, OAUTH_CONSUMER_SECRET, OAUTH_APP_ID);
    if (is_object($session)) {
        $user = $session->getSessionedUser();
        $profile = $user->getProfile();
        $name = $profile->nickname; // Getting user name
        $guid = $profile->guid; // Getting Yahoo ID

        //Retriving the user
        $query = mysql_query("SELECT guid,name from yahoo_users where guid = '".$guid."' and oauth_type = 'yahoo'") or die (mysql_error());
        $result = mysql_fetch_array($query);

        if (empty($result)) {
            // user not present in Database. Store a new user and Create new account for him
            $query = mysql_query("INSERT INTO yahoo_users(oauth_type, guid, name) VALUES('yahoo', '".$guid."', '".$name."')") or die (mysql_error());
            $query = mysql_query("SELECT guid,name from yahoo_users where guid = '".$guid."' and oauth_type = 'yahoo'") or die (mysql_error());
            $result = mysql_fetch_array($query);
        }
        // Creating session variable for User
        $_SESSION['login'] = true;
        $_SESSION['name'] = $result['name'];
        $_SESSION['guid'] = $result['guid'];
        $_SESSION['oauth_provider'] = 'yahoo';
    }
}

if (array_key_exists("logout", $_GET)) {
    // User logging out and Clearing all Session data
    YahooSession::clearSession();
    unset ($_SESSION['login']);
    unset($_SESSION['name']);
    unset($_SESSION['guid']);
    unset($_SESSION['oauth_provider']);
    // After logout Redirection here
    header("Location: index.php");
}
?>
