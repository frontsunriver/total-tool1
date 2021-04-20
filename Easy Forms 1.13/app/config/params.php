<?php

return [
    // Mailer
    'App.Mailer.transport' => 'php', // 'smtp' or 'php'
    // Async Email Notifications
    'App.Mailer.async' => 0, // 0 (Disabled) or 1 (Enabled)
    // GridView
    'GridView.pagination.pageSize' => 5,
    // List Group
    'ListGroup.listSize' => 5,
    // Google Maps API Key
    // https://developers.google.com/maps/documentation/javascript/get-api-key
    'Google.Maps.apiKey' => '',
    // Cron Jobs
    'App.Cron.cronKey' => '8BQlz1y9E1l5Z09yOyiMjLgvY6P9U6YD', // Unauthorized access protection
    'App.Mailer.cronExpression' => '* * * * *', // Process mail queue every minute
    'App.Analytics.cronExpression' => '@daily', // Update analytics every day
    // Overwrite PHP Path
    'App.Console.phpPath' => '', // Absolute path to php. Eg. '/usr/bin/php'
    // Restrict access to login page by IP
    'App.User.validIps' => [
        // '::1', // localhost
    ],
    // Session Timeout
    'App.User.SessionTimeout.value' => 1200000, // Milliseconds. 0 (Disabled) or 1200000 (20 minutes)
    'App.User.SessionTimeout.warning' => 30000, // Milliseconds. 0 (Disabled) or 30000 (30 seconds)
];