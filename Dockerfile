FROM php:8.3-apache

# Install PDO MySQL driver
RUN docker-php-ext-install pdo pdo_mysql

# Ensure single MPM module (mpm_prefork) to prevent AH00534 conflict
RUN a2dismod mpm_event mpm_worker 2>/dev/null || true && a2enmod mpm_prefork

# Suppress Apache ServerName warning
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Support dynamic PORT environment variable (Railway, Render, Cloud default)
ENV PORT=80
RUN sed -i "s/80/\${PORT}/g" /etc/apache2/ports.conf /etc/apache2/sites-available/000-default.conf

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Recommended PHP production/development settings
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

WORKDIR /var/www/html

EXPOSE 80
