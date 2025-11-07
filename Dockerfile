FROM php:8.4-fpm

# Set working directory
WORKDIR /var/www/html

ARG CACHE_TIMESTAMP="$(date +%s)"

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
    netcat-openbsd \
    gosu

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

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create user with UID 1000 to match host user
RUN groupadd -g 1000 appuser && \
    useradd -u 1000 -g appuser -m -s /bin/bash appuser

# Copy entrypoint script
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Create necessary directories and set ownership
RUN mkdir -p /var/www/html/storage /var/www/html/bootstrap/cache && \
    chown -R appuser:appuser /var/www/html && \
    chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Switch to non-root user
USER appuser

# Expose PHP-FPM port
EXPOSE 9000

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["php-fpm"]