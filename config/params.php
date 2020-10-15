<?php

return [
    'adminEmail' => 'admin@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',

    // overridden in params-local.php
    'Twilio' => [
        'TWILIO_ACCOUNT_SID' => '<sid>',
        'TWILIO_AUTH_TOKEN' => '<token>',
        'TWILIO_NUMBER' => '<number>'
    ],
];
