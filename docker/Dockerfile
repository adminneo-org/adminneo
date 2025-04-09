FROM webdevops/php-nginx:8.3-alpine

ENV SERVICE_NGINX_CLIENT_MAX_BODY_SIZE=512M
ENV PHP_POST_MAX_SIZE=256M
ENV PHP_UPLOAD_MAX_FILESIZE=256M
ENV PHP_MEMORY_LIMIT=2G

# Install dependencies
RUN apk add --update --no-cache gnupg autoconf g++ make unixodbc-dev

# https://learn.microsoft.com/en-us/sql/connect/odbc/linux-mac/installing-the-microsoft-odbc-driver-for-sql-server?view=sql-server-ver16&tabs=alpine18-install%2Calpine17-install%2Cdebian8-install%2Credhat7-13-install%2Crhel7-offline
# Download mssql packages
RUN curl -O https://download.microsoft.com/download/fae28b9a-d880-42fd-9b98-d779f0fdd77f/msodbcsql18_18.5.1.1-1_amd64.apk
RUN curl -O https://download.microsoft.com/download/fae28b9a-d880-42fd-9b98-d779f0fdd77f/msodbcsql18_18.5.1.1-1_amd64.sig

# Verify signature
RUN curl https://packages.microsoft.com/keys/microsoft.asc | gpg --import -
RUN gpg --verify msodbcsql18_18.5.1.1-1_amd64.sig msodbcsql18_18.5.1.1-1_amd64.apk

# Install the packages
RUN apk add --allow-untrusted msodbcsql18_18.5.1.1-1_amd64.apk
RUN rm msodbcsql18_18.5.1.1-1_amd64.apk

# Install pdo_odbc
RUN pecl install sqlsrv pdo_sqlsrv
RUN docker-php-ext-enable sqlsrv pdo_sqlsrv

# Cleanup
RUN apk del gnupg autoconf g++ make unixodbc-dev
RUN rm -rf /var/cache/apk/*

# Install AdminNeo dev
ARG CACHE_BUST=1
RUN git clone --single-branch --depth 1 https://github.com/adminneo-org/adminneo.git

WORKDIR /adminneo
RUN composer install
RUN php bin/compile.php mysql,pgsql,mssql,mongo,elastic,clickhouse,simpledb default+

RUN mkdir /app/plugins/
RUN cp export/adminneo.php /app/
RUN cp plugins/*.php /app/plugins/

WORKDIR /
RUN rm -rf adminneo

# Copying index.php
COPY ./index.php /app/
#COPY ./info.php /app/

EXPOSE 80
