#!/bin/sh
set -e

cd /var/www/html

export PORT="${PORT:-8000}"
export QUEUE_WORKERS="${QUEUE_WORKERS:-1}"
FPM_MAX_CHILDREN="${FPM_MAX_CHILDREN:-8}"

sed -i "s/__PORT__/${PORT}/" /etc/nginx/http.d/default.conf

# "zzz-" para cargarse después del zz-docker.conf de la imagen oficial y ganarle.
cat > /usr/local/etc/php-fpm.d/zzz-app.conf <<CONF
[www]
user = www-data
group = www-data
listen = 127.0.0.1:9000
pm = dynamic
pm.max_children = ${FPM_MAX_CHILDREN}
pm.start_servers = 2
pm.min_spare_servers = 1
pm.max_spare_servers = 3
pm.max_requests = 500
request_terminate_timeout = 300
; Sin esto php-fpm borra las variables de entorno que inyecta Dokploy.
clear_env = no
catch_workers_output = yes
decorate_workers_output = no
CONF

# Si Dokploy monta un volumen en storage/, puede llegar con dueño root. Livewire guarda
# las subidas temporales en storage/app/private/livewire-tmp.
mkdir -p storage/logs storage/app/public storage/app/private/livewire-tmp \
    storage/framework/cache/data storage/framework/sessions storage/framework/views bootstrap/cache
chown www-data:www-data storage storage/app storage/app/public storage/app/private
chown -R www-data:www-data storage/logs storage/framework bootstrap/cache storage/app/private/livewire-tmp

# Archivos que quedaron de root (p. ej. un `php artisan` corrido en la terminal del
# contenedor) rompen las subidas: se devuelven a www-data.
find storage/app ! -user www-data -exec chown www-data:www-data {} +

# Migraciones y cachés con las variables de runtime, como www-data para que los archivos
# generados no queden de root. Dockerfile.dev pone SKIP_LARAVEL_CACHE=1 para que los
# cambios de variables y vistas se vean con solo reiniciar.
su-exec www-data php artisan migrate --force
su-exec www-data php artisan view:clear

if [ "${SKIP_LARAVEL_CACHE:-0}" != "1" ]; then
    su-exec www-data php artisan config:cache
    su-exec www-data php artisan route:cache
    su-exec www-data php artisan view:cache
fi

exec supervisord -c /etc/supervisord.conf
