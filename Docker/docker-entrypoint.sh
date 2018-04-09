#!/usr/bin/env bash

echo Starting server

set -u
set -e

DB_HOST=${SYMFONY__TOURBUZZ__DATABASE_HOST:-tourbuzz-db.service.consul}
DB_PORT=${SYMFONY__TOURBUZZ__DATABASE_PORT:-5432}

cat > /srv/web/tourbuzz-api/app/config/parameters.yml <<EOF
parameters:
   database_host: ${DB_HOST}
   database_port: ${DB_PORT}
   database_name: ${SYMFONY__TOURBUZZ__DATABASE_NAME}
   database_user: ${SYMFONY__TOURBUZZ__DATABASE_USER}
   database_password: ${SYMFONY__TOURBUZZ__DATABASE_PASSWORD}
   mailer_transport: ${SYMFONY__TOURBUZZ__MAILER_TRANSPORT}
   mailer_host: ${SYMFONY__TOURBUZZ__MAILER_HOST}
   mailer_user: ${SYMFONY__TOURBUZZ__MAILER_USER}
   mailer_password: ${SYMFONY__TOURBUZZ__MAILER_PASSWORD}
   mailer_port: ${SYMFONY__TOURBUZZ__MAILER_PORT}
   mailer_encryption: ${SYMFONY__TOURBUZZ__MAILER_ENCRYPTION}
   mail_from: ${SYMFONY__TOURBUZZ__MAIL_FROM}
   mail_cc: ${SYMFONY__TOURBUZZ__MAIL_CC}
   auto_login_from_email: ${SYMFONY__TOURBUZZ__AUTO_LOGIN_FROM_EMAIL}
   retention_policy: ${SYMFONY__TOURBUZZ__RETENTION_POLICY}
   secret: ${SYMFONY__TOURBUZZ__SECRET}
   messagebird_accountkey: ${SYMFONY__TOURBUZZ__MESSAGEBIRD_API_KEY}
   messagebird_enable: ${SYMFONY__TOURBUZZ__MESSAGEBIRD_ENABLE}
   sms_originator: ${SYMFONY__TOURBUZZ__SMS_ORGINATOR}
   piwik_site_id: ${SYMFONY__TOURBUZZ__PIWIK_SITE_ID}
   sms_disable: false
   trusted_proxies:
        - 127.0.0.1
        - 10.0.0.0/8
        - 172.16.0.0/12
        - 192.168.0.0/16
EOF

#php tourbuzz-api/bin/console assetic:dump --env=prod
#php tourbuzz-api/bin/console assets:install
#php tourbuzz-api/bin/console cache:clear --env=prod
#php /srv/web/tourbuzz-api/vendor/bin/doctrine-migrations mig:mig --configuration=/srv/web/tourbuzz-api/migrations.yml

# Again, just to be sure
#chown -R www-data:www-data /srv/web/tourbuzz-api/var && chmod -R 0770 /srv/web/tourbuzz-api/var

service php7.0-fpm start
nginx -g "daemon off;"