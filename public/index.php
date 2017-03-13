<?php

require_once '../include/class/box.php';
require_once '../include/class/lang.php';

// i18n
\Box::obj('Lang')->set();

require_once '../config/config.php';
require_once '../include/class/control.php';
require_once '../include/class/helper.php';

// Third-Party Dependencies
require '../vendor/autoload.php';

$core = new Control();

// shared item
\Box::obj('db',   $cfg_db_medoo);
\Box::obj('mail', $cfg_mail_PHPMailer);

\Box::val('cfg_title', $cfg_title);
\Box::val('cfg_brand', $cfg_brand);
\Box::val('cfg_mod',   $cfg_mod);
\Box::val('cfg_nav',   $cfg_nav);



$core->make();