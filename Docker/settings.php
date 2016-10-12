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
                'host'     => '127.0.0.1',
                'dbname'   => 'tourapi',
                'user'     => 'vagrant',
                'password' => 'vagrant',
            ]
        ],
        'haltesUrl'              => 'http://open.datapunt.amsterdam.nl/ivv/touringcar/in_uitstaphaltes.json',
        'messagesUrl'            => 'http://api.docker.tourbuzz.b.nl/berichten/' . date("Y/m/d"),
        'parkeerUrl'             => 'http://open.datapunt.amsterdam.nl/ivv/touringcar/parkeerplaatsen.json',
        'wachtwoordVergetenUrl'  => 'http://www.docker.tourbuzz.b.nl/wachtwoordvergeten/',
        'mailConfirmUrl'         => 'http://www.docker.tourbuzz.b.nl/mailbevestigen/',
        'mailUnsubscribeUrl'     => 'http://www.docker.tourbuzz.b.nl/mailannuleren/',
        'imageStoreRootPath'     => 'images/',
        'imageStoreExternalPath' => 'http://api.docker.tourbuzz.b.nl/images/',
        'imageResizeUrl'         => 'http://api.docker.tourbuzz.b.nl/afbeeldingen/',
        'translateApiKey'        => 'placeholder',
        'fromMail'               => 'noreply@tourbuzz.nl',
        'sendgridApiKey'         => 'placeholder',
        'messagebirdApiKey'      => 'placeholder'
    ]
];