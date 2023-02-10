FROM php:8.0.27-apache


ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN chmod +x /usr/local/bin/install-php-extensions

RUN apt update && apt install -y libicu-dev && rm -rf /var/lib/apt/lists/*
RUN docker-php-ext-install intl


RUN install-php-extensions mysqli pdo pdo_mysql

RUN install-php-extensions mbstring gd zip mysqlnd

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer


RUN a2enmod rewrite
RUN service apache2 restart