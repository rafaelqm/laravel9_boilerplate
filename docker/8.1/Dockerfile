FROM ubuntu:20.04

LABEL maintainer="Taylor Otwell"
# Import the XDEBUG flag
ARG XDEBUG

ARG WWWGROUP

WORKDIR /var/www/html

ENV DEBIAN_FRONTEND noninteractive
ENV TZ=UTC

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

RUN apt-get update \
    && apt-get install -y gnupg gosu curl ca-certificates zip unzip git supervisor sqlite3 libcap2-bin libpng-dev python2 \
    && mkdir -p ~/.gnupg \
    && chmod 600 ~/.gnupg \
    && echo "disable-ipv6" >> ~/.gnupg/dirmngr.conf \
    && apt-key adv --homedir ~/.gnupg --keyserver hkp://keyserver.ubuntu.com:80 --recv-keys E5267A6C \
    && apt-key adv --homedir ~/.gnupg --keyserver hkp://keyserver.ubuntu.com:80 --recv-keys C300EE8C \
    && echo "deb http://ppa.launchpad.net/ondrej/php/ubuntu focal main" > /etc/apt/sources.list.d/ppa_ondrej_php.list \
    && apt-get update \
    && apt-get install -y php8.0-cli php8.0-dev \
       php8.0-pgsql php8.0-sqlite3 php8.0-gd \
       php8.0-curl php8.0-memcached \
       php8.0-imap php8.0-mysql php8.0-mbstring \
       php8.0-xml php8.0-zip php8.0-bcmath php8.0-soap \
       php8.0-intl php8.0-readline \
       php8.0-msgpack php8.0-igbinary php8.0-ldap \
       php8.0-redis php-xml \
    && php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer \
    && curl -sL https://deb.nodesource.com/setup_16.x | bash - \
    && apt-get install -y nodejs \
    && curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add - \
    && echo "deb https://dl.yarnpkg.com/debian/ stable main" > /etc/apt/sources.list.d/yarn.list \
    && apt-get update \
    && apt-get install -y yarn \
    && apt-get install -y mysql-client \
    && apt-get install -y postgresql-client \
    && apt-get -y autoremove \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Install Xdebug if required
RUN if ${XDEBUG} ; then \
    apt-get update \
    && apt-get install -y php8.0-xdebug \
    && apt-get -y autoremove \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*; \
fi;

RUN pecl channel-update https://pecl.php.net/channel.xml
RUN pecl install swoole
RUN pecl clear-cache
RUN rm -rf /tmp/* /var/tmp/*

RUN setcap "cap_net_bind_service=+ep" /usr/bin/php8.0

RUN groupadd --force -g $WWWGROUP sail
RUN useradd -ms /bin/bash --no-user-group -g $WWWGROUP -u 1337 sail

COPY start-container /usr/local/bin/start-container
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY php.ini /etc/php/8.0/cli/conf.d/99-sail.ini
RUN chmod +x /usr/local/bin/start-container

RUN apt-get update && apt-get upgrade -y
RUN apt-get install wget -y
RUN cd ~ && wget https://github.com/wkhtmltopdf/packaging/releases/download/0.12.6-1/wkhtmltox_0.12.6-1.focal_amd64.deb
RUN cd ~ && apt-get install fontconfig libxrender1 xfonts-75dpi xfonts-base -y
RUN cd ~ && dpkg -i wkhtmltox_0.12.6-1.focal_amd64.deb
RUN cd ~ && apt-get --fix-broken install
RUN cd ~ && dpkg -i wkhtmltox_0.12.6-1.focal_amd64.deb
RUN apt-get install php8.1-cli php8.1-dev php8.1-swoole \
  php8.1-pgsql php8.1-sqlite3 php8.1-gd \
  php8.1-curl php8.1-memcached \
  php8.1-imap php8.1-mysql php8.1-mbstring \
  php8.1-xml php8.1-zip php8.1-bcmath php8.1-soap \
  php8.1-intl php8.1-readline \
  php8.1-msgpack php8.1-igbinary php8.1-ldap \
  php8.1-redis -y

RUN if ${XDEBUG} ; then \
    apt-get update \
    && apt-get install -y php8.1-xdebug \
    && apt-get -y autoremove \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*; \
fi;

EXPOSE 8000

ENTRYPOINT ["start-container"]
