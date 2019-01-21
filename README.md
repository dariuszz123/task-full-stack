# CRUD test app

## Live demo

API Client: https://ht-client.darneta.lt/  
API: https://ht-api.darneta.lt/  

## Documentation

* See api/README.md
* See client/README.md

## Development server

### Requirements

* Docker 18.09+ (might work on older too, not tested)
* Docker-compose 1.14+ (might work on older too, not tested)

### Run

0. (optional) build containers `docker-compose -f docker-compose.dev.yml build`
1. `docker-compose -f docker-compose.dev.yml up`
2. Get fronted container ip `docker inspect -f '{{range .NetworkSettings.Networks}}{{.IPAddress}}{{end}}' hostinger_test_client`
3. Open browser at http://{FRONTEND_CONTAINER_IP}:4200

### Run API tests

1. Get inside container `docker exec -ti -u application hostinger_test_api bash`
2. Get to project dir `cd /app`
3. Run phpunit `./bin/phpunit`
