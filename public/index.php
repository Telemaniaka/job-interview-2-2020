<?php
require __DIR__ . '/../vendor/autoload.php';

use Recruitment\MailTask\App;
use Recruitment\MailTask\Service\VoidOutput;
use Recruitment\MailTask\Service\StaticFileConfig;

$output = new VoidOutput();
$config = new StaticFileConfig('../src/Config/conf.php');
$app    = new App($output, $config);
$app->run();
