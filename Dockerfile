FROM nginx:1.17
MAINTAINER apps@tiltshift.nl

ENV TOURBUZZ__ENVIRONMENT acc.
ENV TOURBUZZ__DATABASE_HOST database
ENV TOURBUZZ__DATABASE_PORT 5432
ENV TOURBUZZ__DATABASE_NAME tourbuzz
ENV TOURBUZZ__DATABASE_USER tourbuzz
ENV TOURBUZZ__DATABASE_PASSWORD insecure
ENV TOURBUZZ__MESSAGEBIRD_ENABLE true
ENV TOURBUZZ__MESSAGEBIRD_API_KEY insecure
ENV TOURBUZZ__TRANSLATE_API_KEY insecure
ENV TOURBUZZ__SENDGRID_API_KEY insecure
EXPOSE 80

# install php packages
RUN apt-get update \
 && apt-get install -y apt-transport-https ca-certificates \

RUN apt-get update && apt-get -y install git wget cron rsync curl unzip \
  php-fpm \
  php-intl \
  php-pgsql \
  php-curl \
  php-cli \
  php-gd \
  php-mbstring \
  # php-mcrypt \ DEPRECATED
  php-opcache \
  php-sqlite3 \
  php-xml \
  php-xsl \
  php-zip \
  php-igbinary \
  php-json \
  php-memcached \
  php-msgpack \
  php-xmlrpc \
  php-imagick \
 && apt-get -y upgrade \
 && apt-get clean


# project setup
COPY . /srv/web/tourbuzz-api
WORKDIR /srv/web
RUN wget https://getcomposer.org/composer.phar
# nginx and php setup
COPY Docker/tourbuzz-api.vhost /etc/nginx/conf.d/tourbuzz-api.vhost.conf
RUN rm /etc/nginx/conf.d/default.conf \
  && sed -i '/\;listen\.mode\ \=\ 0660/c\listen\.mode=0666' /etc/php/7.0/fpm/pool.d/www.conf \
  && sed -i '/pm.max_children = 5/c\pm.max_children = 20' /etc/php/7.0/fpm/pool.d/www.conf \
  && sed -i '/\;pm\.max_requests\ \=\ 500/c\pm\.max_requests\ \=\ 100' /etc/php/7.0/fpm/pool.d/www.conf \
  && echo "server_tokens off;" > /etc/nginx/conf.d/extra.conf \
  && echo "client_max_body_size 20m;" >> /etc/nginx/conf.d/extra.conf \
  && echo "client_body_buffer_size 20m;" >> /etc/nginx/conf.d/extra.conf \
  && sed -i '/upload_max_filesize \= 2M/c\upload_max_filesize \= 20M' /etc/php/7.0/fpm/php.ini \
  && sed -i '/post_max_size \= 8M/c\post_max_size \= 21M' /etc/php/7.0/fpm/php.ini \
  && sed -i '/\;date\.timezone \=/c\date.timezone = Europe\/Amsterdam' /etc/php/7.0/fpm/php.ini \
  && sed -i '/\;security\.limit_extensions \= \.php \.php3 \.php4 \.php5 \.php7/c\security\.limit_extensions \= \.php' /etc/php/7.0/fpm/pool.d/www.conf \
  && sed -e 's/;clear_env = no/clear_env = no/' -i /etc/php/7.0/fpm/pool.d/www.conf

RUN chown www-data:www-data /srv/web/tourbuzz-api/cache/proxies
# only install dependencies
ENV COMPOSER_ALLOW_SUPERUSER 1
RUN php composer.phar install -d tourbuzz/tourbuzz/ --prefer-dist --no-progress --no-scripts

# run
COPY Docker/docker-entrypoint.sh /docker-entrypoint.sh
# Fixes: permission denied error while launching container
RUN chmod +x /docker-entrypoint.sh
CMD /docker-entrypoint.sh
