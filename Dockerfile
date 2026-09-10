FROM php:8.3-apache

# Install ekstensi database MySQL
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Hindari peringatan ServerName
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Dukungan dynamic PORT bawaan Railway
ENV PORT=80
RUN sed -i "s/80/\${PORT}/g" /etc/apache2/ports.conf /etc/apache2/sites-available/000-default.conf

# Aktifkan rewrite module
RUN a2enmod rewrite

# Rekomendasi PHP production settings
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

WORKDIR /var/www/html

COPY . /var/www/html/

RUN chown -R www-data:www-data /var/www/html

EXPOSE 80

# Kunci solusi MPM: hapus paksa mpm_event & mpm_worker di runtime, pastikan prefork aktif, lalu jalankan apache
CMD ["bash", "-c", "rm -f /etc/apache2/mods-enabled/mpm_event.* /etc/apache2/mods-enabled/mpm_worker.* && a2enmod mpm_prefork && exec apache2-foreground"]