<?php

if (file_exists(__DIR__ . '/params-local.php')) {
    $params = array_merge(
        require(__DIR__ . '/params.php'),
        require(__DIR__ . '/params-local.php')
    );
} else {
    $params = require __DIR__ . '/params.php';
}

return $params;