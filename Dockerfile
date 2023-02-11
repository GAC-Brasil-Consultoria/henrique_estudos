FROM php:8.0.27-apache

# Set running user to the host user
ARG USER_ID
ARG GROUP_ID
RUN userdel -f www-data &&\
    if getent group www-data ; then groupdel www-data; fi &&\
    groupadd -g ${GROUP_ID} www-data &&\
    useradd -l -u ${USER_ID} -g www-data www-data &&\
    install -d -m 0755 -o www-data -g www-data /home/www-data

# Install PHP extensions
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install system dependencies
RUN apt update && apt install -y libicu-dev && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN install-php-extensions mysqli pdo pdo_mysql mbstring gd zip mysqlnd intl

RUN a2enmod rewrite