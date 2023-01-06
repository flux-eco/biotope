FROM phpswoole/swoole:php8.2-alpine as  flux-eco-biotope

ENV FLUX_ECO_HTTP_SERVER_SIDECAR_PORT=9501
ENV FLUX_ECO_HTTP_SERVER_SIDECAR_WORKER_NUM=10
ENV FLUX_ECO_HTTP_SERVER_SIDECAR_BACKLOG=2048
ENV FLUX_ECO_HTTP_SERVER_SIDECAR_INDEX_FILES=/index.html
ENV FLUX_ECO_HTTP_SERVER_SIDECAR_LOG_FILE_PATH_NAME=/var/log/flux-eco-http-server-sidecar/server.log
ENV FLUX_ECO_HTTP_SERVER_SIDECAR_AUTOLOAD_FILE_PATH=/app/autoload.php
ENV FLUX_ECO_HTTP_SERVER_SIDECAR_HTTP_API_FQCN=NULL

# |-------------------------------------------------------------------------- \
# | apk update
# | Update the index of available packages
# |
# | apk upgrade
# | Upgrade the currently installed packages
# |-------------------------------------------------------------------------- \

# root access
USER root
RUN \
    apk update && \
    apk upgrade
# Switch back to default user
USER www-data


# |-------------------------------------------------------------------------- \
# | LINUX inotify-tools | https://github.com/inotify-tools/inotify-tools/wiki
# | used for directory / file watchers - not for recursively watchers
# |
# | LINUX tree | https://pkgs.alpinelinux.org/package/v3.4/main/x86/tree
# | used for implementing recursively directory / file watchers
# |-------------------------------------------------------------------------- \

# root access
USER root
RUN \
  # Install
  apk --no-cache add inotify-tools tree
# Switch back to default user
USER www-data


# |--------------------------------------------------------------------------
# | PHP gettext | https://www.php.net/manual/de/book.gettext.php
# |--------------------------------------------------------------------------

# root access
USER root
RUN \
    # Install dependencies
    apk --no-cache add gettext-dev && \
    # Install
    apk --no-cache add php-gettext
# Switch back to default user
USER www-data


# |-------------------------------------------------------------------------- \
# | PHP pdo pdo_mysql
# | mysql clients
# |-------------------------------------------------------------------------- \

# root access
USER root
RUN docker-php-ext-install mysqli pdo_mysql
RUN docker-php-ext-enable pdo_mysql
# Switch back to default user
USER www-data

# |-------------------------------------------------------------------------- \
# | PHP soap
# |-------------------------------------------------------------------------- \

# root access
USER root
RUN \
    apk add \
    libxml2-dev \
    php8-soap
USER www-data
USER root
RUN \
  # Install
  docker-php-ext-install soap && \
  # Enable
  docker-php-ext-enable soap
# Switch back to default user
USER www-data


# |--------------------------------------------------------------------------
# | PHP YAML | https://www.php.net/manual/de/book.yaml.php
# |--------------------------------------------------------------------------

USER root
RUN \
    apk --no-cache add yaml-dev
# Download latest known YAML Extension
ARG YAML_VERSION=2.2.2
RUN mkdir -p /usr/src/php/ext/yaml \
    && curl -L https://github.com/php/pecl-file_formats-yaml/archive/$YAML_VERSION.tar.gz | tar xvz -C /usr/src/php/ext/yaml --strip 1 \
    && echo 'yaml' >> /usr/src/php-available-exts \
    # Install extension
    && docker-php-ext-install yaml
# Switch back to default user
USER www-data

# |--------------------------------------------------------------------------
# | Create Default Log Directory
# |--------------------------------------------------------------------------
USER root
RUN mkdir -p /var/log/flux-eco-http-server-sidecar/
RUN chown -R www-data:www-data /var/log/flux-eco-http-server-sidecar/
USER www-data

# |--------------------------------------------------------------------------
# | COPY flux-eco-http-server-sidecar to /opt/flux-eco-http-server-sidecar
# |--------------------------------------------------------------------------
USER root
COPY --chown=www-data:www-data ./opt/flux-eco-http-server-sidecar /opt/flux-eco-http-server-sidecar
USER www-data
WORKDIR /app