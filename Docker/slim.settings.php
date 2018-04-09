<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => true, // Allow the web server to send the content-length header

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],
        'doctrine' => [
            'meta' => [
                'entity_path' => [
                    'src/entity'
                ],
                'auto_generate_proxies' => true,
                'proxy_dir' =>  __DIR__.'/../cache/proxies',
                'cache' => null,
            ],
            'connection' => [
                'driver'   => 'pdo_pgsql',
                'host'     => 'database',
                'dbname'   => 'tourapi',
                'user'     => 'tourapi',
                'password' => '5b67G40YzkbgcUi4tHKP46IKWD5xEr5I',
            ]
        ],
        'haltesUrl'              => 'http://open.datapunt.amsterdam.nl/ivv/touringcar/in_uitstaphaltes.json',
        'messagesUrl'            => 'http://tourapi.b.nl/berichten/' . date("Y/m/d"),
        'parkeerUrl'             => 'http://open.datapunt.amsterdam.nl/ivv/touringcar/parkeerplaatsen.json',
        'wachtwoordVergetenUrl'  => 'http://tour.b.nl/wachtwoordvergeten/',
        'mailConfirmUrl'         => 'http://tour.b.nl/mailbevestigen/',
        'mailUnsubscribeUrl'     => 'http://tour.b.nl/mailannuleren/',
        'imageStoreRootPath'     => 'images/',
        'imageStoreExternalPath' => 'http://tourapi.b.nl/images/',
        'imageResizeUrl'         => 'http://tourapi.b.nl/afbeeldingen/',
        'translateApiKey'        => 'placeholder',
        'fromMail'               => 'noreply@tourbuzz.nl',
        'sendgridApiKey'         => 'placeholder',
        'messagebirdApiKey'      => 'placeholder'
    ]
];