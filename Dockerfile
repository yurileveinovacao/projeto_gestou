FROM php:7.4-apache

# Composer (multi-stage) — necessário pra instalar PHPWord
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Timezone (Brasil) — afeta SO e PHP via date.timezone
ENV TZ=America/Sao_Paulo

# Install system dependencies for PHP extensions + tzdata + LibreOffice (pra conversão docx→pdf FEA-008)
RUN apt-get update && apt-get install -y --no-install-recommends \
    tzdata \
    libpq-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libzip-dev \
    libicu-dev \
    libcurl4-openssl-dev \
    libonig-dev \
    libreoffice-writer \
    libreoffice-core \
    libreoffice-java-common \
    default-jre-headless \
    && ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone \
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

# PHP settings: upload limits + error logging to stderr (Cloud Run captures stderr) + timezone Brasil
RUN echo "upload_max_filesize=20M\npost_max_size=25M\nmemory_limit=512M\nlog_errors=On\nerror_log=/dev/stderr\ndisplay_errors=Off\noutput_buffering=65536\ndate.timezone=America/Sao_Paulo" > /usr/local/etc/php/conf.d/php-settings.ini

# Copy application code and vendors
COPY . /var/www/html/

# Install PHPWord via Composer in its isolated vendor folder (admin/vendor_phpword)
RUN cd /var/www/html/admin/vendor_phpword \
    && composer install --no-dev --no-interaction --prefer-dist --no-progress \
    && rm -rf /root/.composer/cache

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
