FROM php:apache-buster

COPY pixel-canvas.ini /usr/local/etc/php/conf.d/pixel-canvas.ini

RUN apt-get update && \
    apt-get install -y git zip postgresql libpq-dev libpng-dev libjpeg-dev libfreetype6-dev

RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pgsql pdo_pgsql

RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

RUN mkdir -p /var/www/html/public

COPY pixel-canvas.conf /etc/apache2/sites-available/pixel-canvas.conf

RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf &&\
    a2enmod rewrite &&\
    a2dissite 000-default &&\
    a2ensite pixel-canvas &&\
    service apache2 restart

#RUN curl --silent --show-error https://getcomposer.org/installer | php && \
#    mv composer.phar /usr/local/bin/composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
#COPY composer.json composer.json
#COPY composer.lock composer.lock
#RUN composer install --no-dev
