FROM php:7.2-apache

RUN a2enmod rewrite

RUN apt-get update && apt-get install -y \
	zlib1g-dev curl zip \
	git unzip wget

RUN pecl install xdebug-2.6.0 \
    && docker-php-ext-enable xdebug \
	&& echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_autostart=off" >> /usr/local/etc/php/conf.d/xdebug.ini

RUN docker-php-ext-install -j$(nproc) mysqli pdo pdo_mysql zip \
    && apt-get -y autoremove \
	&& apt-get clean \
	&& rm -rf  /var/lib/apt/lists/* /tmp/* /var/tmp/*

ENV APACHE_DOCUMENT_ROOT /var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN curl -sS https://getcomposer.org/installer | php \
	&& mv composer.phar /usr/bin/composer
    
WORKDIR /var/www/html/