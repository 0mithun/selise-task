
## Requirements
- docker, docker-compose



## Installation Instructions

- Run `docker compose run php composer install`
- Run `docker compose run php php artisan migrate:fresh --seed`
- Run `cp .env.example .env`
- Set DB_HOST=db in .env
- Run `docker compose run php php artisan key:generate`
- Run `docker compose run node npm install`
- Run `docker compose up -d`


## Run Application
- Run `docker compose up -d`
- Open http://127.0.0.1:8000/


## API Docs
- For HTML Version Inside public/docs folder open index.html
- For OpenAPI Version Inside public/docs folder openapi.yaml
- For Postman Version Inside public/docs folder collection.json
