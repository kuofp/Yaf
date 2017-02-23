<?php
require_once '../config/config.php';
require_once '../include/class/control.php';
require_once '../include/class/auth.php';
require_once '../include/class/helper.php';
require_once '../include/class/box.php';

// Third-Party Dependencies
require '../vendor/autoload.php';

$core = new Control();

// shared item
$di = new Box();
$di->obj('db',   $cfg_db_medoo);
$di->obj('mail', $cfg_mail_PHPMailer);

$di->val('cfg_title', $cfg_title);
$di->val('cfg_brand', $cfg_brand);
$di->val('cfg_mod',   $cfg_mod);
$di->val('cfg_nav',   $cfg_nav);

$core->make();