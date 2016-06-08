<?php
require_once 'include/config/nav.inc.php';
require_once 'include/class/control.class.php';
require_once 'include/class/form.class.php';
require_once 'include/class/auth.class.php';

// Third-Party Dependencies
require 'vendor/autoload.php';


session_start();
$htmlbase = new Control();

// database
$database = $htmlbase->newMedoo($cfg_db_medoo);
// $database = $htmlbase->newSOME_ORM($cfg_db_SOME_CONFIG);

// mail
$mailbase = $htmlbase->newPHPMailer($cfg_mail_PHPMailer);
// $mailbase = $htmlbase->newSOME_MAILER($cfg_mail_SOME_MAILER);


$module = $htmlbase->get('m')?:'index';
$htmlbase->make($module);


?>