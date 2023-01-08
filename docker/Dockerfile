FROM phpswoole/swoole:php8.2-alpine as  flux-eco-biotope

ENV FLUX_ECO_HTTP_SYNAPSE_PORT=9501
ENV FLUX_ECO_HTTP_SYNAPSE_WORKER_NUM=10
ENV FLUX_ECO_HTTP_SYNAPSE_BACKLOG=2048
ENV FLUX_ECO_HTTP_SYNAPSE_INDEX_FILES=/index.html
ENV FLUX_ECO_HTTP_SYNAPSE_LOG_FILE_PATH_NAME=/var/log/flux-eco-http-synapse/server.log
ENV FLUX_ECO_HTTP_SYNAPSE_AUTOLOAD_FILE_PATH=NULL
ENV FLUX_ECO_HTTP_SYNAPSE_HTTP_API_FQCN=NULL

ENV FLUX_ECO_MESSAGE_STREAM_ORBITAL_PROTOCOL=http
ENV FLUX_ECO_MESSAGE_STREAM_ORBITAL_HOST=flux-eco-message-logger-orbital
ENV FLUX_ECO_MESSAGE_STREAM_ORBITAL_PORT=9501

ENV FLUX_ECO_DISPATCHER_SYNAPSE_CONFIG_DIRECTORY_PATH=/opt/flux-eco-dispatcher-synapse/config
ENV FLUX_ECO_DISPATCHER_SYNAPSE_FROM_PROTOCOL=http
ENV FLUX_ECO_DISPATCHER_SYNAPSE_FROM_HOST=NULL
ENV FLUX_ECO_DISPATCHER_SYNAPSE_FROM_PORT=9501

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
RUN mkdir -p /var/log/flux-eco-http-synapse/
RUN chown -R www-data:www-data /var/log/flux-eco-http-synapse/
USER www-data

# |--------------------------------------------------------------------------
# | COPY flux-eco-installer-orbital, flux-eco-http-synapse, flux-eco-dispatcher-synapse
# |--------------------------------------------------------------------------
USER root

COPY --chown=www-data:www-data ./opt/flux-eco-installer-orbital/app/bin/flux-eco-installer-orbital.extract-archive-url-to-folder /usr/local/bin/flux-eco-installer-orbital.extract-archive-url-to-folder
RUN chmod a+rx /usr/local/bin/flux-eco-installer-orbital.extract-archive-url-to-folder

COPY --chown=www-data:www-data ./opt/flux-eco-http-synapse/app/bin/flux-eco-http-synapse.start /usr/local/bin/flux-eco-http-synapse.start
RUN chmod a+rx /usr/local/bin/flux-eco-http-synapse.start
COPY --chown=www-data:www-data ./opt/flux-eco-http-synapse/app /opt/flux-eco-http-synapse/app

COPY --chown=www-data:www-data ./opt/flux-eco-dispatcher-synapse /opt/flux-eco-dispatcher-synapse

RUN mkdir -p FLUX_ECO_DISPATCHER_SYNAPSE_CONFIG_DIRECTORY_PATH
RUN chown -R www-data:www-data FLUX_ECO_DISPATCHER_SYNAPSE_CONFIG_DIRECTORY_PATH

USER www-data

WORKDIR /opt