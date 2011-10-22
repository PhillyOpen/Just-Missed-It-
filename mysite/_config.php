<?php

global $project;
$project = 'mysite';

global $database;
$database = 'septa';

// Use _ss_environment.php file for configuration
require_once("conf/ConfigureFromEnv.php");


MySQLDatabase::set_connection_charset('utf8');

/* URL Rules for Map View */
Director::addRules(50, array('bus/$Action/$ID/$OtherID' => 'Page_Controller'));

// This line set's the current theme. More themes can be
// downloaded from http://www.silverstripe.org/themes/
SSViewer::set_theme('blackcandy');

// Set the site locale
i18n::set_locale('en_US');

// enable nested URLs for this site (e.g. page/sub-page/)
SiteTree::enable_nested_urls();
