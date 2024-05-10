FROM fedora:40 AS dev-site

EXPOSE 8080

RUN dnf upgrade -y && \
    dnf install -y composer nginx php-fpm php-json php-opcache php-xml php-gd php-curl php-mysqlnd php-mbstring php-pecl-imagick php-pecl-zip php-zip php-pecl-xdebug && \
    sed -i '/^;clear_env/s/^;//' /etc/php-fpm.d/www.conf && \
    sed -i '/upload_max_filesize/s/= *2M/= 50M/' /etc/php.ini && \
    mkdir /run/php-fpm && \
    rm -f /etc/nginx/nginx.conf && \
    ln -s /app/config/nginx.conf /etc/nginx/nginx.conf

FROM fedora:40 AS dev-theme

EXPOSE 5173

RUN dnf upgrade -y && dnf install -y 'dnf-command(config-manager)'
RUN dnf config-manager --add-repo https://dl.yarnpkg.com/rpm/yarn.repo
RUN dnf upgrade -y && dnf install -y yarn composer

WORKDIR /build/web/app/themes/chrisn-xyz/

FROM fedora:40 AS builder

ENV COMPOSER_ALLOW_SUPERUSER=1

RUN dnf upgrade -y && dnf install -y 'dnf-command(config-manager)'
RUN dnf config-manager --add-repo https://dl.yarnpkg.com/rpm/yarn.repo
RUN dnf upgrade -y && dnf install -y yarn composer

COPY config /build/config/
COPY web /build/web/
COPY composer.json /build/composer.json
COPY composer.lock /build/composer.lock

WORKDIR /build
RUN composer install

WORKDIR /build/web/app/themes/chrisn-xyz/
RUN yarn && yarn build && rm -rf node_modules

FROM fedora:40

EXPOSE 8080

RUN dnf upgrade -y && \
    dnf install -y nginx php-fpm php-json php-opcache php-xml php-gd php-curl php-mysqlnd php-mbstring php-pecl-imagick php-pecl-zip php-zip && \
    sed -i '/^;clear_env/s/^;//' /etc/php-fpm.d/www.conf && \
    sed -i '/upload_max_filesize/s/= *2M/= 50M/' /etc/php.ini && \
    mkdir /run/php-fpm

COPY config/nginx.conf /etc/nginx/nginx.conf
COPY --from=builder /build /app/

CMD nginx; /usr/sbin/php-fpm --nodaemonize
