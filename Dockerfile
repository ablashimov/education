FROM php:8.4.13-cli AS dev

ENV COMPOSER_HOME=/tmp/composer
ENV APPLICATION_DIRECTORY=/app

# Copy custom php.ini
COPY php.ini /usr/local/etc/php/conf.d/custom.ini

ARG USER_NAME=laravel
ARG USER_ID=1000
ARG GROUP_ID=1000

RUN groupadd -g $GROUP_ID $USER_NAME && \
    useradd -u $USER_ID -g $USER_NAME -m $USER_NAME


RUN apt-get update \
    && apt-get install -y \
    curl \
    libicu-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libpq-dev \
    nodejs \
    npm \
    libzip-dev \
    ca-certificates \
    && update-ca-certificates \
    && mkdir -p /var/www/.npm && chown -R $USER_NAME:$USER_NAME /var/www/.npm \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*


RUN pecl install redis \
    && docker-php-ext-enable redis

RUN docker-php-ext-configure intl \
    && docker-php-ext-configure pdo_pgsql \
    && docker-php-ext-install exif pcntl bcmath gd intl soap pdo_pgsql zip sockets

COPY --from=composer:2.5.8 /usr/bin/composer /usr/bin/composer
RUN mkdir -p /.npm && chown -R $USER_NAME:$USER_NAME /.npm

USER $USER_NAME
WORKDIR $APPLICATION_DIRECTORY

COPY --chown=$USER_NAME:$USER_NAME ./composer.json ./ ./composer.lock ./
COPY --chown=$USER_NAME:$USER_NAME ./package.json ./ ./package-lock.json ./

RUN npm install

COPY --chown=$USER_NAME:$USER_NAME . ./

EXPOSE 8000
RUN chmod +x ./entrypoint.sh
ENTRYPOINT ["/app/entrypoint.sh"]
CMD ["php", "artisan", "octane:start", "--watch", "--workers=4", "--host=0.0.0.0", "--port=8000"]