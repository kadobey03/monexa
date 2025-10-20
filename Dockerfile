FROM php:8.3-fpm

# Set working directory
WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libmcrypt-dev \
    libgd-dev \
    libgmp-dev \
    jpegoptim optipng pngquant gifsicle \
    vim \
    nano \
    cron \
    supervisor \
    netcat-openbsd

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions required for Laravel 12
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip gmp

# Install GD extension with freetype and jpeg support
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

# Install Redis extension
RUN pecl install redis && docker-php-ext-enable redis

# Install OPcache extension
RUN docker-php-ext-install opcache

# Get latest Composer - with fallback for Docker Hub issues
COPY --from=composer:2.7.1 /usr/bin/composer /usr/bin/composer

# Copy existing application directory contents
COPY . /var/www/html

# Copy existing application directory permissions
COPY --chown=www-data:www-data . /var/www/html

# Install PHP dependencies for Laravel 12
RUN composer install --no-dev --optimize-autoloader --no-interaction --ignore-platform-req=ext-gmp --ignore-platform-req=php --no-scripts || \
    composer update --no-dev --optimize-autoloader --no-interaction --ignore-platform-req=ext-gmp --ignore-platform-req=php --no-scripts

# Create necessary directories and set permissions
RUN mkdir -p /var/www/html/storage/logs \
    && mkdir -p /var/www/html/storage/framework/cache \
    && mkdir -p /var/www/html/storage/framework/sessions \
    && mkdir -p /var/www/html/storage/framework/views \
    && mkdir -p /var/www/html/storage/framework/testing \
    && mkdir -p /var/www/html/bootstrap/cache

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

# Copy the startup script
COPY docker/scripts/start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

# Expose port 9000 and start php-fpm server
EXPOSE 9000

CMD ["/usr/local/bin/start.sh"]