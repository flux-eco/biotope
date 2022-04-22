FROM phpswoole/swoole:latest-alpine as flux-biotope

# |-------------------------------------------------------------------------- \
# | author martin@fluxlabs.ch
# |-------------------------------------------------------------------------- \


# |-------------------------------------------------------------------------- \
# | General Environment Variables
# |-------------------------------------------------------------------------- \
ENV SWOOLE_HTTP_PORT=80
ENV SWOOLE_HTTP_WORKER_NUM=1
ENV SWOOLE_HTTP_MAX_CONN=10000
ENV SWOOLE_HTTP_MAX_REQUEST=10000
# SWOOLE_IPC_MSGQUEUE
ENV SWOOLE_HTTP_IPC_MODE=2
ENV SWOOLE_HTTP_TASK_WORKER_NUM=1
# SWOOLE_IPC_MSGQUEUE
ENV SWOOLE_HTTP_TASK_IPC_MODE=2
ENV SWOOLE_HTTP_TASK_MAX_REQUEST=5000
ENV SWOOLE_HTTP_DISPATCH_MODE=1
ENV SWOOLE_HTTP_DAEMONIZE=0
ENV SWOOLE_HTTP_BACKLOG=2048
ENV SWOOLE_HTTP_OPEN_TCP_KEEPALIVE=1
ENV SWOOLE_HTTP_TCP_DEFER_ACCEPT=5
ENV SWOOLE_HTTP_OPEN_TCP_NODELAY=1
ENV SWOOLE_HTTP_LOG_FILE_PATH_NAME="/var/log/swoole/http.log"


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
#USER root
#RUN \
#    apk add busybox-extras
# Switch back to default user
#USER www-data



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


#www-data persmissions on /var/www
USER root
RUN chown -R www-data:www-data /var/www
USER www-data