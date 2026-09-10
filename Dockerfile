FROM php:8.3-apache

# Install PDO MySQL driver
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Nonaktifkan modul MPM lain secara bersih dan pastikan hanya prefork yang aktif
RUN a2dismod -f mpm_event mpm_worker || true \
    && a2enmod mpm_prefork rewrite

# Suppress Apache ServerName warning
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Support dynamic PORT environment variable untuk Railway
ENV PORT=80
RUN sed -i "s/80/\${PORT}/g" /etc/apache2/ports.conf /etc/apache2/sites-available/000-default.conf

# Rekomendasi PHP production settings
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

WORKDIR /var/www/html

# Salin kode aplikasi
COPY . /var/www/html/

# Pastikan permission aman
RUN chown -R www-data:www-data /var/www/html

# Bersihkan jika ada file konfigurasi apache nyasar yang terbawa dari copy
RUN a2dismod -f mpm_event mpm_worker || true

EXPOSE 80

CMD ["apache2-foreground"]