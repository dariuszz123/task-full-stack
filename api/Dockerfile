FROM webdevops/php-nginx-dev:alpine-php7
ENV WEB_DOCUMENT_ROOT=/app/public
ENV APP_ENV=prod
COPY . /app
RUN chown -R application:application /app
USER application
WORKDIR /app
RUN composer install --no-dev --optimize-autoloader
USER root
CMD ["/app/bin/start.sh"]
