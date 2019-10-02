<?php

namespace App;

require_once 'vendor/autoload.php';

use Dotenv\Dotenv;
use Nesk\Puphpeteer\Puppeteer;
use SimpleLog\Logger;

$dotenv = Dotenv::create(__DIR__);
$dotenv->load();

$puppeteer = new Puppeteer([
]);
$browser   = $puppeteer->launch([
    'executablePath'  => getenv('CHROMIUM_PATH'),
    'defaultViewport' => [
        'width'            => 800,
        'height'           => 800,
        'logger'           => new Logger('/dev/stdout', 'default'),
        'log_node_console' => true,
        'debug'            => true,
    ],
    'args'            => [
        '--no-sandbox', '--disable-setuid-sandbox',
    ],
]);

$page = $browser->newPage();
$page->goto('https://ankiweb.net/account/login');

$page->type('#email', getenv('ANKI_WEB_ID'));
$page->type('#password', getenv('ANKI_WEB_PW'));
$page->screenshot(['path' => '/app/test.png']);