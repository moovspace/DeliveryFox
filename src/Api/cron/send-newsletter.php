<?php
// Add file to cron jobs in linux
require("../../../phpini.php");
require("../../../vendor/autoload.php");

use MyApp\App\Email\SendNewsletterCron;

// Send 100 per instance or run
SendNewsletterCron::Send(300);
?>