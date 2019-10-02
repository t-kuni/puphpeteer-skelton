<?php

namespace App;

require_once 'vendor/autoload.php';

use Dotenv\Dotenv;
use Nesk\Puphpeteer\Puppeteer;
use Nesk\Rialto\Data\JsFunction;
use SimpleLog\Logger;

$dotenv = Dotenv::create(__DIR__);
$dotenv->load();

$logger = new Logger('/dev/stdout', 'default');

$puppeteer = new Puppeteer([
]);
$browser   = $puppeteer->launch([
    'executablePath'  => getenv('CHROMIUM_PATH'),
    'defaultViewport' => [
        'width'            => 800,
        'height'           => 800,
        'logger'           => $logger,
        'log_node_console' => true,
        'debug'            => true,
    ],
    'args'            => [
        '--no-sandbox', '--disable-setuid-sandbox',
    ],
]);

$logger->info('ログイン開始');
$page = $browser->newPage();
$page->goto('https://ankiweb.net/account/login');
$page->type('#email', getenv('ANKI_WEB_ID'));
$page->type('#password', getenv('ANKI_WEB_PW'));
$page->querySelector('input[type="submit"]')->press('Enter');
$page->waitForNavigation();
//$page->screenshot(['path' => '/app/test.png']);
$logger->info('ログイン終了');

$logger->info('カード追加開始');
$page->goto('https://ankiuser.net/edit/');
$page->querySelectorEval('#deck', JsFunction::createWithParameters(['node'])
    ->body('node.value = ""'));
$page->type('#deck', '000_test');
$page->type('#f0', 'test');
$page->type('#f1', 'test');
$page->querySelector('button.btn-primary')->press('Enter');
//$page->screenshot(['path' => '/app/test.png']);
$logger->info('カード追加完了');

$browser->close();