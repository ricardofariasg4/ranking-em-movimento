FROM php:8.3-apache

# Dependências do sistema
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    libzip-dev \
    && rm -rf /var/lib/apt/lists/*

# Habilita extensões necessárias
RUN docker-php-ext-install pdo pdo_mysql zip

# Habilita mod_rewrite
RUN a2enmod rewrite

# Ajusta DocumentRoot para /public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/*.conf \
    /etc/apache2/apache2.conf

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

# Copia o projeto
COPY . /var/www/html
WORKDIR /var/www/html

RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Permissões
RUN chown -R www-data:www-data /var/www/html