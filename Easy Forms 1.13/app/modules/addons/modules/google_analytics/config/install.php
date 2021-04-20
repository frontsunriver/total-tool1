<?php

$config = [
    'id' => 'google_analytics',
    'name'=> 'Google Analytics',
    'class' => 'app\modules\addons\modules\google_analytics\Module',
    'description'=> [
        'en-US' => 'Get user data of each form in Google Analytics. Know how many view, fill and submit your forms.',
        'es-ES' => 'Captura los datos de tus usuarios en Google Analytics. Conoce cuantas personas han visto, llenado y enviado tus formularios.',
    ],
    'version' => '1.2',
];

return $config;
