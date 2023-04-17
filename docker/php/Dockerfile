ARG PHP_VERSION=8.1

FROM php:${PHP_VERSION}-fpm

#RUN curl -L https://phar.phpunit.de/phpunit.phar > /tmp/phpunit.phar \
#    && chmod +x /tmp/phpunit.phar \
#    && mv /tmp/phpunit.phar /usr/local/bin/phpunit

# Install OS utilities
RUN apt-get update # -o Acquire::CompressionTypes::Order::=gz --allow-releaseinfo-change
RUN apt-get -y install \
    msmtp \
    mailutils \
    curl \
    iputils-ping \
    net-tools \
    git \
    libzip-dev \
    libonig-dev \
    wget \
    dnsutils \
    zlib1g-dev \
    libicu-dev\
    g++ \
    vim \
    watch \
    libcurl4-gnutls-dev \
    gettext \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libpng-dev \
    libxml2-dev \
    libxslt-dev \
    unzip

RUN apt-get -y install \
    librabbitmq-dev \
    libssl-dev

RUN apt-get update && apt-get install -y zlib1g-dev libicu-dev g++

RUN pecl install amqp
RUN pecl install xdebug


RUN docker-php-ext-install pcntl
RUN docker-php-ext-enable amqp

RUN docker-php-ext-configure intl
RUN docker-php-ext-install intl
RUN docker-php-ext-install soap
RUN docker-php-ext-install sysvsem
RUN docker-php-ext-install calendar

RUN docker-php-ext-install zip
RUN docker-php-ext-install xsl
RUN docker-php-ext-install curl
RUN docker-php-ext-install mysqli
RUN docker-php-ext-install pdo pdo_mysql
RUN docker-php-ext-install mbstring
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install -j$(nproc) gd
RUN docker-php-ext-enable xdebug
RUN docker-php-ext-enable calendar

# RUN pecl install redis && docker-php-ext-enable redis

COPY ../../composer.json composer.json
COPY ../../composer.lock composer.lock
#COPY ./docker/php/docker-entrypoint.sh docker-entrypoint.sh
#RUN chmod +x php.sh
# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN mkdir /var/composer
ENV COMPOSER_HOME /var/composer
ENV COMPOSER_ALLOW_SUPERUSER 1

#RUN composer install

# Add repo
# RUN composer config --global repositories.bellvision composer https://package.bellvision.fr

WORKDIR /app

#RUN composer install --working-dir=.

#ENTRYPOINT ['/usr/bin/composer', 'install', 'php-fpm']

#CMD ["php-fpm"]
#CMD ["./docker/php/init/01.sh"]
#CMD ["php-fpm", "--daemonize", "&&", "composer", "install"]
#ENTRYPOINT ['docker-entrypoint.sh']

EXPOSE 9000
