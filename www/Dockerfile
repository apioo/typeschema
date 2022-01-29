FROM php:8.0-apache
MAINTAINER Christoph Kappestein <christoph.kappestein@apioo.de>
LABEL description="TypeSchema website

ENV COMPOSER_VERSION "2.1.9"
ENV COMPOSER_SHA256 "4d00b70e146c17d663ad2f9a21ebb4c9d52b021b1ac15f648b4d371c04d648ba"

# install composer
RUN wget -O /usr/bin/composer https://getcomposer.org/download/${COMPOSER_VERSION}/composer.phar
RUN echo "${COMPOSER_SHA256} */usr/bin/composer" | sha256sum -c -
RUN chmod +x /usr/bin/composer

# install app
COPY . /var/www/html
RUN cd /var/www/html && /usr/bin/composer install
