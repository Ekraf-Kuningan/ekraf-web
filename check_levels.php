<?php

require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->boot();

use App\Models\Level;

$levels = Level::all();
echo "Levels in database:" . PHP_EOL;
foreach ($levels as $level) {
    echo "ID: {$level->id_level}, Level: {$level->level}" . PHP_EOL;
}
