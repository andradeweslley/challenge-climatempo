####################################################################
#                   Dockerfile for Laravel/Lumen                   #
####################################################################

# ------------- Setup Environment -------------------------------------------------------

# Pull base image
FROM ubuntu:20.04

# Fix timezone
ENV TZ=America/Sao_Paulo
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

# Install common tools 
RUN apt-get update
RUN apt-get install -y \
    wget \
    curl \
    nano \
    htop \
    git \
    unzip \
    bzip2 \
    software-properties-common \ 
    locales

# Set evn var to enable xterm terminal
ENV TERM=xterm

# Set working directory
WORKDIR /var/www/html

# Add repositories
RUN LC_ALL=C.UTF-8 apt-add-repository ppa:ondrej/php
RUN apt-key adv --keyserver keyserver.ubuntu.com --recv-keys ABF5BD827BD9BF62
RUN apt-key adv --keyserver keyserver.ubuntu.com --recv-keys 4F4EA0AAE5267A6C
RUN echo "deb http://nginx.org/packages/ubuntu/ trusty nginx" >> /etc/apt/sources.list
RUN echo "deb-src http://nginx.org/packages/ubuntu/ trusty nginx" >> \ 
    /etc/apt/sources.list


# ------------- Application Specific Stuff ----------------------------------------------

# Install PHP
RUN apt-get update
RUN apt-get install -y \
    php8.1-fpm \ 
    php8.1-common \ 
    php8.1-curl \ 
    php8.1-mysql \ 
    php8.1-mbstring \ 
    php8.1-xml \
    php8.1-bcmath \
    php8.1-gd \
    php8.1-xdebug
	
# config xdebug to allow run clover_coverage 
RUN echo "xdebug.mode=coverage" >> /etc/php/8.1/mods-available/xdebug.ini 

# ------------- FPM & Nginx configuration -----------------------------------------------

# Config fpm to use TCP instead of unix socket
ADD docker/www.conf /etc/php/8.1/fpm/pool.d/www.conf
RUN mkdir -p /var/run/php

# Add user to nginx
RUN useradd -s /bin/false nginx

# Install nginx
RUN apt-get install -y nginx

# Move especific application config
ADD docker/clima_tempo /etc/nginx/sites-enabled/

# Move nginx config
ADD docker/nginx.conf /etc/nginx/

# ------------- Composer ----------------------------------------------------------------

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin \
    --filename=composer

# ------------- Supervisor Process Manager ----------------------------------------------

# Install supervisor
RUN apt-get install -y supervisor
RUN mkdir -p /var/log/supervisor
ADD docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# ------------- Container Config --------------------------------------------------------

# Copy application folder to docker (use only in production)
#ADD ./ /var/www/html

# Remove folder with docker configs (can't add this folder in .dockerignore because 
# it will be ignored before starts the build and not be able to ADD config file above)
#RUN rm -rf docker 

# Expose port 8000
EXPOSE 8000

# Set supervisor to manage container processes
ENTRYPOINT ["/usr/bin/supervisord"]
