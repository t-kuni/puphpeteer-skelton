<?php

namespace App;

require_once 'vendor/autoload.php';

use Dotenv\Dotenv;
use Nesk\Puphpeteer\Puppeteer;

$dotenv = Dotenv::create(__DIR__);
$dotenv->load();

$puppeteer = new Puppeteer([
]);
$browser   = $puppeteer->launch([
    'executablePath'  => getenv('CHROMIUM_PATH'),
    'defaultViewport' => [
        'width'             => 800,
        'height'            => 800,
    ],
    'args'            => [
        '--no-sandbox', '--disable-setuid-sandbox',
    ],
]);

$page = $browser->newPage();
$page->goto('https://google.com');
$page->screenshot(['path' => '/app/test.png']);