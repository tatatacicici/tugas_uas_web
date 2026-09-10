FROM php:8.3-fpm-alpine

# Install Nginx dan ekstensi database MySQL
RUN apk add --no-cache nginx \
    && docker-php-ext-install pdo pdo_mysql mysqli

# Siapkan direktori kerja
WORKDIR /var/www/html

# Salin seluruh kode aplikasi
COPY . /var/www/html/

# Atur permission
RUN chown -R www-data:www-data /var/www/html \
    && mkdir -p /run/nginx

# Konfigurasi Nginx untuk PHP dan dukungan PORT dinamis Railway
RUN echo 'server { \
    listen ENV_PORT default_server; \
    root /var/www/html; \
    index index.php index.html; \
    server_name _; \
    location / { \
        try_files $uri $uri/ /index.php?$query_string; \
    } \
    location ~ \.php$ { \
        fastcgi_pass 127.0.0.1:9000; \
        fastcgi_index index.php; \
        include fastcgi_params; \
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name; \
    } \
}' > /etc/nginx/http.d/default.conf

# Script startup untuk mapping PORT Railway dan menjalankan Nginx + PHP-FPM
CMD sh -c "sed -i \"s/ENV_PORT/${PORT:-80}/g\" /etc/nginx/http.d/default.conf && php-fpm -D && nginx -g 'daemon off;'"