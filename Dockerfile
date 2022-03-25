FROM phpswoole/swoole:latest-alpine as flux-biotope

# |-------------------------------------------------------------------------- \
# | author martin@fluxlabs.ch
# |-------------------------------------------------------------------------- \


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
# | busybox-extras
# | e.g. telnet
# |
# |-------------------------------------------------------------------------- \

# root access
USER root
RUN \
    apk add busybox-extras
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


# |-------------------------------------------------------------------------- \
# | PHP pdo pdo_mysql
# | mysql clients
# |-------------------------------------------------------------------------- \

# root access
USER root
RUN \
  # Install
  docker-php-ext-install pdo pdo_mysql && \
  # Enable
  docker-php-ext-enable pdo_mysql
# Switch back to default user
USER www-data


# |-------------------------------------------------------------------------- \
# | PHP php8-curl
# |-------------------------------------------------------------------------- \

# root access
USER root
RUN \
  # Install \
  apk add curl-dev && \
  docker-php-ext-install curl && \
  # Enable
  docker-php-ext-enable curl
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
    docker-php-ext-install gettext
# Switch back to default user
USER www-data


# |--------------------------------------------------------------------------
# | PHP YAML | https://www.php.net/manual/de/book.yaml.php
# |--------------------------------------------------------------------------

USER root
RUN \
    apk --no-cache add yaml-dev
# Download latest known YAML Extension
ENV YAML_VERSION 2.2.1
RUN mkdir -p /usr/src/php/ext/yaml &&\
        curl -L https://github.com/php/pecl-file_formats-yaml/archive/$YAML_VERSION.tar.gz | tar xvz -C /usr/src/php/ext/yaml --strip 1 &&\
        echo 'yaml' >> /usr/src/php-available-exts && \
    # Install extension
    docker-php-ext-install yaml
# Switch back to default user
USER www-data

#www-data persmissions on /var/www
USER root
RUN chown -R www-data:www-data /var/www
USER www-data