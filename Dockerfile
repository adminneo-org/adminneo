FROM php:7.1-apache
#FROM php:8.3.7-apache

RUN apt-get update 

COPY app/ /var/www/html/

EXPOSE 80