# Default Dockerfile
#
# @link     https://www.hyperf.io
# @document https://doc.hyperf.io
# @contact  group@hyperf.io
# @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE

FROM hyperf/hyperf:7.4-alpine-v3.11-cli
LABEL maintainer="Hyperf Developers <group@hyperf.io>" version="1.0" license="MIT"

##
# ---------- env settings ----------
##
# --build-arg timezone=Asia/Shanghai
ARG timezone

ENV TIMEZONE=${timezone:-"Asia/Shanghai"} \
    COMPOSER_VERSION=1.9.1 \
    APP_ENV=prod \
    SCAN_CACHEABLE=(true) \
    #  install and remove building packages
    PHPIZE_DEPS="autoconf  g++ gcc make php7-dev php7-pear zlib-dev re2c"

# update
RUN set -ex \
    && apk update \
    && apk add --virtual .build-deps $PHPIZE_DEPS \
    && ln -s /usr/bin/phpize7 /usr/local/bin/phpize \
    && ln -s /usr/bin/php-config7 /usr/local/bin/php-config \
    # install xlswriter
    && pecl install xlswriter \
    && echo "extension=xlswriter.so" > /etc/php7/conf.d/xlswriter.ini \
    && echo -e "install xlswriter" \
    #  install libiconv libdatrie trie-filter
    && cd /tmp \
    && wget http://ftp.gnu.org/pub/gnu/libiconv/libiconv-1.14.tar.gz \
    && tar -zxvf libiconv-1.14.tar.gz \
    && cd libiconv-1.14  \
    && cd srclib/ \
    && sed -i -e '/gets is a security/d' ./stdio.in.h \
    && cd .. \
    && ./configure  \
    && make && make install \
    && ln -s /usr/local/lib/libiconv.so /usr/lib \
    && ln -s /usr/local/lib/libiconv.so.2 /usr/lib \
    && wget https://linux.thai.net/pub/ThaiLinux/software/libthai/libdatrie-0.2.11.tar.xz  \
    && tar -xvf libdatrie-0.2.11.tar.xz  \
    && cd libdatrie-0.2.11  \
    && ./configure --prefix=/usr/local/libdatrie  \
    && make ICONV_LIBS='/usr/local/lib/libiconv.so'  \
    && make install \
    && wget https://github.com/wulijun/php-ext-trie-filter/archive/master.zip \
    && unzip master.zip \
    && cd php-ext-trie-filter-master/  \
    && phpize \
    && ./configure --with-php-config=/usr/local/bin/php-config --with-trie_filter=/usr/local/libdatrie/ \
    && make \
    && make install \
    && echo "extension=trie_filter.so" > /etc/php7/conf.d/trie_filter.ini \
    && echo -e "install trie_filter" \
    # install composer
    && cd /tmp \
    && wget https://github.com/composer/composer/releases/download/${COMPOSER_VERSION}/composer.phar \
    && chmod u+x composer.phar \
    && mv composer.phar /usr/local/bin/composer \
    # show php version and extensions
    && php -v \
    && php -m \
    #  ---------- some config ----------
    && cd /etc/php7 \
    # - config PHP
    && { \
        echo "upload_max_filesize=100M"; \
        echo "post_max_size=108M"; \
        echo "memory_limit=1024M"; \
        echo "date.timezone=${TIMEZONE}"; \
    } | tee conf.d/99-overrides.ini \
    # - config timezone
    && ln -sf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime \
    && echo "${TIMEZONE}" > /etc/timezone \
    # ---------- clear works ----------
    && apk del .build-deps \
    && rm -rf /var/cache/apk/* /tmp/* /usr/share/man \
    && echo -e "\033[42;37m Build Completed :).\033[0m\n"

WORKDIR /opt/www

# Composer Cache
COPY ./composer.* /opt/www/
RUN composer install --no-dev --no-scripts

COPY . /opt/www
RUN composer install --no-dev -o && php bin/hyperf.php
#
EXPOSE 9501

ENTRYPOINT ["php", "/opt/www/bin/hyperf.php", "start"]
