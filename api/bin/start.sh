#!/bin/bash
su - application -c "cd /app;bin/console --env=prod doctrine:migrations:migrate --no-interaction"
supervisord