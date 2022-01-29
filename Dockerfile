FROM php:8.0-apache
MAINTAINER Christoph Kappestein <christoph.kappestein@apioo.de>
LABEL description="TypeSchema website"

ENV COMPOSER_VERSION "2.1.9"
ENV COMPOSER_SHA256 "4d00b70e146c17d663ad2f9a21ebb4c9d52b021b1ac15f648b4d371c04d648ba"

ENV APACHE_DOCUMENT_ROOT "/var/www/html/public"

# install default packages
RUN apt-get update && apt-get -y install \
    wget \
    cron \
    certbot \
    python3-certbot-apache \
    libcurl3-dev \
    libzip-dev

# install php extensions
RUN docker-php-ext-install \
    bcmath \
    curl \
    zip \
    mbstring

# install composer
RUN wget -O /usr/bin/composer https://getcomposer.org/download/${COMPOSER_VERSION}/composer.phar
RUN echo "${COMPOSER_SHA256} */usr/bin/composer" | sha256sum -c -
RUN chmod +x /usr/bin/composer

# adjust apache config
RUN sed -ri -e "s!/var/www/html!${APACHE_DOCUMENT_ROOT}!g" /etc/apache2/sites-available/*.conf
RUN sed -ri -e "s!/var/www/!${APACHE_DOCUMENT_ROOT}!g" /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
RUN a2enmod rewrite

# install app
COPY www /var/www/html
RUN cd /var/www/html && /usr/bin/composer install
RUN chown -R www-data: /var/www/html
