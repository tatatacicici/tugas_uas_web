FROM php:8.3-fpm-alpine

# Install Nginx dan driver database MySQL
RUN apk add --no-cache nginx gettext \
    && docker-php-ext-install pdo pdo_mysql mysqli

WORKDIR /var/www/html

COPY . /var/www/html/

RUN chown -R www-data:www-data /var/www/html \
    && mkdir -p /run/nginx /var/log/nginx

# Template konfigurasi Nginx
RUN echo 'server { \
    listen ${PORT} default_server; \
    root /var/www/html; \
    index index.php index.html Admin.php; \
    location / { \
        try_files $uri $uri/ /index.php?$query_string; \
    } \
    location ~ \.php$ { \
        fastcgi_pass 127.0.0.1:9000; \
        fastcgi_index index.php; \
        include fastcgi_params; \
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name; \
    } \
}' > /etc/nginx/http.d/default.conf.template

# Buat runner script agar port Railway terpasang otomatis dan kedua proses berjalan
RUN echo '#!/bin/sh' > /start.sh \
    && echo 'export PORT=${PORT:-80}' >> /start.sh \
    && echo 'envsubst "\$PORT" < /etc/nginx/http.d/default.conf.template > /etc/nginx/http.d/default.conf' >> /start.sh \
    && echo 'php-fpm -D' >> /start.sh \
    && echo 'exec nginx -g "daemon off;"' >> /start.sh \
    && chmod +x /start.sh

CMD ["/start.sh"]