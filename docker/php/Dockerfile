FROM php:8.2-fpm
RUN apt-get update && apt-get install -y \
		libfreetype-dev \
		libjpeg62-turbo-dev \
		libpng-dev \
        iputils-ping \
        telnet \
		libcurl4-openssl-dev \
        libmcrypt-dev \
        libzip-dev \
		libicu-dev\
		libonig-dev\
	&& docker-php-ext-configure gd --with-freetype --with-jpeg \
	&& docker-php-ext-install -j$(nproc) gd pdo_mysql zip
# Install the intl extension
RUN docker-php-ext-install intl \
# enable the intl extension
    && docker-php-ext-enable intl
# Install the mbstring extension
RUN docker-php-ext-install mbstring \
# enable the mbstring extension
    && docker-php-ext-enable mbstring
# Install the curl extension
RUN docker-php-ext-install curl \
# enable the curl extension
    && docker-php-ext-enable curl
RUN docker-php-ext-configure opcache --enable-opcache \
    && docker-php-ext-install opcache

RUN pecl install xdebug-3.2.1 \
	&& docker-php-ext-enable xdebug

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Config PHP ini
COPY ./php.ini /usr/local/etc/php/php.ini
COPY ./ini/* /usr/local/etc/php/conf.d/

COPY ./php-entrypoint.sh /php-entrypoint.sh
RUN chmod u+x /php-entrypoint.sh

RUN mkdir -p /var/www/html/app

WORKDIR /var/www/html/app

ENTRYPOINT ["/php-entrypoint.sh"]

CMD ["php-fpm"]