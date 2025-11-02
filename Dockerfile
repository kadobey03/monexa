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
    netcat-openbsd \
    nginx \
    supervisor \
    su-exec

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

# Create user with same UID/GID as host user
ARG USER_ID=1000
ARG GROUP_ID=1000
RUN groupadd -g ${GROUP_ID} hostgroup && \
    useradd -u ${USER_ID} -g hostgroup -m -s /bin/bash hostuser

# Copy application files first with proper ownership
COPY --chown=hostuser:hostgroup . /var/www/html

# Copy custom PHP configuration
COPY docker/php/local.ini /usr/local/etc/php/conf.d/local.ini

# Create necessary directories with proper ownership
RUN mkdir -p /var/www/html/storage/logs \
    && mkdir -p /var/www/html/storage/framework/cache \
    && mkdir -p /var/www/html/storage/framework/sessions \
    && mkdir -p /var/www/html/storage/framework/views \
    && mkdir -p /var/www/html/storage/framework/testing \
    && mkdir -p /var/www/html/storage/app/public \
    && mkdir -p /var/www/html/bootstrap/cache

# Install dependencies as hostuser
USER hostuser
RUN composer install --no-dev --optimize-autoloader --no-interaction || echo "Composer install will be handled by entrypoint"

# Switch back to root for final setup
USER root

# Set proper permissions
RUN chown -R hostuser:hostgroup /var/www/html && \
    chmod -R 755 /var/www/html && \
    chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Copy nginx configuration
COPY docker/nginx/default.conf /etc/nginx/sites-available/default
RUN ln -sf /etc/nginx/sites-available/default /etc/nginx/sites-enabled/default && \
    rm -f /etc/nginx/sites-enabled/default

# Create nginx configuration for our Laravel app
RUN echo 'server { \
    listen 80; \
    listen [::]:80; \
    server_name localhost; \
    root /var/www/html/public; \
    index index.php index.html index.htm; \
    \
    add_header X-Frame-Options "SAMEORIGIN" always; \
    add_header X-XSS-Protection "1; mode=block" always; \
    add_header X-Content-Type-Options "nosniff" always; \
    add_header Referrer-Policy "no-referrer-when-downgrade" always; \
    add_header Content-Security-Policy "default-src '\''self'\'' http: https: data: blob: '\''unsafe-inline'\'' '\''unsafe-eval'\''; script-src '\''self'\'' '\''unsafe-inline'\'' '\''unsafe-eval'\'' https: http: cdn.jsdelivr.net unpkg.com cdnjs.cloudflare.com; style-src '\''self'\'' '\''unsafe-inline'\'' https: http: fonts.googleapis.com cdn.jsdelivr.net unpkg.com; img-src '\''self'\'' data: blob: https: http:; font-src '\''self'\'' https: http: data: fonts.gstatic.com; connect-src '\''self'\'' https: http: wss: ws:;" always; \
    \
    server_tokens off; \
    \
    gzip on; \
    gzip_vary on; \
    gzip_min_length 1024; \
    gzip_proxied expired no-cache no-store private auth; \
    gzip_types text/plain text/css text/xml text/javascript application/javascript application/xml+rss application/json application/xml image/svg+xml font/ttf font/opentype application/vnd.ms-fontobject; \
    \
    location / { \
        try_files $uri $uri/ /index.php?$query_string; \
    } \
    \
    location ~ \.php$ { \
        try_files $uri =404; \
        fastcgi_split_path_info ^(.+\.php)(/.+)$; \
        fastcgi_pass 127.0.0.1:9000; \
        fastcgi_index index.php; \
        include fastcgi_params; \
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name; \
        fastcgi_param PATH_INFO $fastcgi_path_info; \
        \
        fastcgi_read_timeout 300; \
        fastcgi_connect_timeout 300; \
        fastcgi_send_timeout 300; \
        fastcgi_buffer_size 128k; \
        fastcgi_buffers 4 256k; \
        fastcgi_busy_buffers_size 256k; \
        fastcgi_temp_file_write_size 256k; \
        fastcgi_intercept_errors on; \
    } \
    \
    location ~* \.(css|js|jpg|jpeg|gif|png|webp|svg|ico|xml|pdf|txt)$ { \
        expires 1y; \
        add_header Cache-Control "public, no-transform, immutable"; \
        add_header Vary "Accept-Encoding"; \
        access_log off; \
        log_not_found off; \
    } \
    \
    location ~ /\. { \
        deny all; \
        access_log off; \
        log_not_found off; \
    } \
    \
    location ~ /\.(htaccess|htpasswd|ini|log|sh|sql|conf|yml|yaml|json)$ { \
        deny all; \
        access_log off; \
        log_not_found off; \
    } \
    \
    location ~ /(composer\.(json|lock)|package\.(json|lock)|\.env)$ { \
        deny all; \
        access_log off; \
        log_not_found off; \
    } \
    \
    location ~ ^/(app|bootstrap|config|database|resources|routes|tests|vendor)/ { \
        deny all; \
        access_log off; \
        log_not_found off; \
    } \
    \
    error_page 404 /index.php; \
    error_page 500 502 503 504 /50x.html; \
    location = /50x.html { \
        root /var/www/html/public; \
    } \
    \
    client_max_body_size 100M; \
    client_body_buffer_size 1M; \
    client_header_buffer_size 4k; \
    large_client_header_buffers 4 8k; \
    client_body_timeout 30s; \
    client_header_timeout 30s; \
    \
    keepalive_timeout 30s; \
    keepalive_requests 1000; \
    send_timeout 30s; \
    reset_timedout_connection on; \
    \
    tcp_nopush on; \
    tcp_nodelay on; \
    \
    sendfile on; \
    sendfile_max_chunk 1m; \
}' > /etc/nginx/sites-available/default

# Copy entrypoint script
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Expose port 80
EXPOSE 80

ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]