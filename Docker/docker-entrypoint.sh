#!/usr/bin/env bash

echo Starting server

set -u
set -e

DB_HOST=${TOURBUZZ__DATABASE_HOST:-tourbuzz-db.service.consul}
DB_PORT=${TOURBUZZ__DATABASE_PORT:-5432}
DB_NAME=${TOURBUZZ__DATABASE_NAME:-tourbuzz}
DB_USER=${TOURBUZZ__DATABASE_USER:-tourbuzz}
DB_PASSWORD=${TOURBUZZ__DATABASE_PASSWORD:-insecure}
MESSAGEBIRD_API_KEY=${TOURBUZZ__MESSAGEBIRD_API_KEY:-placeholder}
TRANSLATE_API_KEY=${TOURBUZZ__TRANSLATE_API_KEY:-placeholder}
SENDGRID_API_KEY=${TOURBUZZ__SENDGRID_API_KEY:-placeholder}
ACC=${TOURBUZZ__ENVIRONMENT:-}

cat > /srv/web/tourbuzz-api/src/settings.php <<EOF
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
                'host'     => '${DB_HOST}',
                'dbname'   => '${DB_NAME}',
                'user'     => '${DB_USER}',
                'password' => '${DB_PASSWORD}',
            ]
        ],
        'haltesUrl'              => 'https://api.data.amsterdam.nl/dcatd/datasets/IuAYhr-__qZj9Q/purls/uEOyRO9EKBNIeA', // 'https://open.data.amsterdam.nl/ivv/touringcar/in_uitstaphaltes.json',
        'messagesUrl'            => 'https://${ACC}api.tourbuzz.nl/berichten/' . date("Y/m/d"),
        'parkeerUrl'             => 'https://api.data.amsterdam.nl/dcatd/datasets/IuAYhr-__qZj9Q/purls/uB95bElRaUcD0A', // 'https://open.data.amsterdam.nl/ivv/touringcar/parkeerplaatsen.json',
        'wachtwoordVergetenUrl'  => 'https://${ACC}tourbuzz.nl/wachtwoordvergeten/',
        'mailConfirmUrl'         => 'https://${ACC}tourbuzz.nl/mailbevestigen/',
        'mailUnsubscribeUrl'     => 'https://${ACC}tourbuzz.nl/mailannuleren/',
        'imageStoreRootPath'     => 'images/',
        'imageStoreExternalPath' => 'https://${ACC}api.tourbuzz.nl/images/',
        'imageResizeUrl'         => 'https://${ACC}api.tourbuzz.nl/afbeeldingen/',
        'translateApiKey'        => '${TRANSLATE_API_KEY}',
        'fromMail'               => 'noreply@tourbuzz.nl',
        'sendgridApiKey'         => '${SENDGRID_API_KEY}',
        'messagebirdApiKey'      => '${MESSAGEBIRD_API_KEY}',
        'datasource' => [
            'recommended_routes' => 'https://api.data.amsterdam.nl/dcatd/datasets/IuAYhr-__qZj9Q/purls/wFSs8bEzvW7S9w', // 'https://open.data.amsterdam.nl/ivv/touringcar/aanbevolen_route.json',
            'mandatory_routes' => 'https://api.data.amsterdam.nl/dcatd/datasets/IuAYhr-__qZj9Q/purls/6PQYbDv09_dhpA', // 'https://open.data.amsterdam.nl/ivv/touringcar/verplichte_route.json',
            'roadwork_routes' => 'https://api.data.amsterdam.nl/dcatd/datasets/IuAYhr-__qZj9Q/purls/csfA78CYaXgnsw', // 'https://open.data.amsterdam.nl/ivv/touringcar/wegwerkzaamheden.json'
        ]
    ]
];
EOF

#php tourbuzz-api/bin/console assetic:dump --env=prod
#php tourbuzz-api/bin/console assets:install
#php tourbuzz-api/bin/console cache:clear --env=prod
#php /srv/web/tourbuzz-api/vendor/bin/doctrine-migrations mig:mig --configuration=/srv/web/tourbuzz-api/migrations.yml

# Again, just to be sure
#chown -R www-data:www-data /srv/web/tourbuzz-api/var && chmod -R 0770 /srv/web/tourbuzz-api/var

touch /srv/web/tourbuzz-api/logs/app.log
chown -R www-data:www-data /srv/web/tourbuzz-api/logs
tail -f /srv/web/tourbuzz-api/logs/app.log &

service php7.0-fpm start
nginx -g "daemon off;"
