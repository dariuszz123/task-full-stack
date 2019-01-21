#!/bin/bash
su - application -c "cd /app;composer install --no-interaction"
su - application -c "cd /app;bin/console doctrine:migrations:migrate --no-interaction"
supervisord
