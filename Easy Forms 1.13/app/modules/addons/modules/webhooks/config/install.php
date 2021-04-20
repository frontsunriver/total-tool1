<?php

$config = [
    'id' => 'webhooks',
    'name'=> 'Webhooks',
    'class' => 'app\modules\addons\modules\webhooks\Module',
    'description'=> [
        'en-US' => 'Send form submission data to a specified URL when a form submission occurs.',
        'es-ES' => 'Envía los datos de los envíos a una URL cuando los formularios son enviados.',
    ],
    'version' => '1.3',
];

return $config;
