<?php
require_once '../config/config.php';
require_once '../include/class/control.class.php';
require_once '../include/class/form.class.php';
require_once '../include/class/auth.class.php';
require_once '../include/class/helper.class.php';

// Third-Party Dependencies
require '../vendor/autoload.php';

$htmlbase = new Control();

// database
$database = new medoo($cfg_db_medoo);

// mail
$mailbase = $htmlbase->newPHPMailer($cfg_mail_PHPMailer);

// do the work
$htmlbase->make();