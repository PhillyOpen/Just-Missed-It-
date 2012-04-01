<?php

global $project;
$project = 'mysite';

$dbname = (getenv("OPENSHIFT_DB_USERNAME") != FALSE) ? $_ENV['OPENSHIFT_DB_USERNAME'] : "septa";
//global $database;
//$database = $dbname;

// Use _ss_environment.php file for configuration
//require_once("conf/ConfigureFromEnv.php");

/* What kind of environment is this: development, test, or live (ie, production */
Director::set_environment_type("dev");

$server = (getenv('OPENSHIFT_DB_HOST') !== FALSE) ? $_ENV['OPENSHIFT_DB_HOST'] : "localhost";
$username = (getenv("OPENSHIFT_DB_USERNAME") != FALSE) ? $_ENV['OPENSHIFT_DB_USERNAME'] : "root";
$password = (getenv("OPENSHIFT_DB_PASSWORD") != FALSE) ? $_ENV['OPENSHIFT_DB_PASSWORD'] : "";

global $databaseConfig;
$databaseConfig = array(
        "type" => 'MySQLDatabase',
        "server" => $server,
        "username" => $username,
        "password" => $password,
        "database" => $dbname,
        "path" => '',
);

MySQLDatabase::set_connection_charset('utf8');
/* URL Rules for Bus View */
Director::addRules(50, array('bus/$Action/$ID/$OtherID' => 'Page_Controller'));
/* URL Rules for Train View */
Director::addRules(50, array('bus/$Action/$ID/$OtherID' => 'Train_Controller'));

// This line set's the current theme. More themes can be
// downloaded from http://www.silverstripe.org/themes/
SSViewer::set_theme('blackcandy');

// Set the site locale
i18n::set_locale('en_US');

// enable nested URLs for this site (e.g. page/sub-page/)
SiteTree::enable_nested_urls();
