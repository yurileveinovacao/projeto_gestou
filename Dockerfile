FROM php:7.4-apache

# Install system dependencies for PHP extensions
RUN apt-get update && apt-get install -y --no-install-recommends \
    libpq-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libzip-dev \
    libicu-dev \
    libcurl4-openssl-dev \
    libonig-dev \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
    pgsql \
    pdo_pgsql \
    gd \
    curl \
    zip \
    intl \
    mbstring

# Enable Apache mod_rewrite (required for .htaccess)
RUN a2enmod rewrite

# Configure Apache to listen on port 8080 (Cloud Run requirement)
RUN sed -i 's/Listen 80/Listen 8080/' /etc/apache2/ports.conf \
    && sed -i 's/:80/:8080/' /etc/apache2/sites-available/000-default.conf

# Allow .htaccess overrides
RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

# Copy application code and vendors
COPY . /var/www/html/

# Use database.php.example as fallback if database.php is missing (gitignored)
RUN if [ ! -f /var/www/html/config/database.php ]; then \
    cp /var/www/html/config/database.php.example /var/www/html/config/database.php; \
    fi

# Create empty upload directories
RUN mkdir -p \
    /var/www/html/upload/beneficios \
    /var/www/html/upload/cadastro \
    /var/www/html/upload/colaboradores \
    /var/www/html/upload/empresa \
    /var/www/html/upload/mensagens \
    /var/www/html/upload/utilidades \
    /var/www/html/admin/uploads \
    /var/www/html/master/upload \
    /var/www/html/downloads \
    && chown -R www-data:www-data \
    /var/www/html/upload \
    /var/www/html/admin/uploads \
    /var/www/html/master/upload \
    /var/www/html/downloads

EXPOSE 8080

CMD ["apache2-foreground"]
