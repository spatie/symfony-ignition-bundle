FROM php:8.2
WORKDIR /var/task
RUN apt-get update -y && apt-get install -y git zip unzip
COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer
