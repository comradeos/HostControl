# HostControl

HostControl is a platform for managing hosting resources,
built with Symfony, MySQL, Docker Compose, and Makefile.

------------------------------------------------------------------------

## Technology Stack

Backend: - PHP 8.3 - Symfony 7 - Doctrine ORM

Database: - MySQL 8

Infrastructure: - Docker Compose - Nginx - PHP-FPM

Code Quality: - PHPUnit - PHPStan - PHP CS Fixer

Additional: - Monolog - Symfony Validator - Symfony Serializer

------------------------------------------------------------------------

## Architecture

Modular Monolith.

Layers: - Controller (HTTP) - Application (Use Cases) - Domain (Business
Logic) - Infrastructure (DB, external services)

------------------------------------------------------------------------

## Project Structure

hostcontrol/ docker/ app/ config/ migrations/ tests/ docs/ Makefile
docker-compose.yml README.md

------------------------------------------------------------------------

## Setup and Run

1.  Clone repository: 
```bash
git clone git@github.com:comradeos/HostControl.git
```

2.  Create env file:
```bash
cp .env.example .env
```

3.  Build containers:
```bash
make build
```

4.  Start project:
```bash
make up
```

5.  Install Symfony (if app is empty):
```bash
make symfony-install
```

6.  Install dependencies:
```bash
make composer-install
```

7.  Install Doctrine: 
```bash
make doctrine-install
```

8.  Run migrations: 
```bash
make migrate
```

9.  Open: http://localhost:8080

------------------------------------------------------------------------

## Makefile Commands

make build 

make up 

make down 

make restart 

make bash

make composer-install 

make doctrine-install 

make migrate 

make test 

make qa

------------------------------------------------------------------------

## API

Response format:

{ "result": true, "data": {} }

------------------------------------------------------------------------

## Database

-   Doctrine ORM
-   Migrations
-   Indexes
-   Foreign keys

------------------------------------------------------------------------

## Testing

-   Unit tests
-   Integration tests

------------------------------------------------------------------------

## Performance

-   Indexing
-   Pagination
-   Avoid N+1
-   Query optimization

------------------------------------------------------------------------

## Logging

-   Monolog
-   Centralized error handling

------------------------------------------------------------------------

## Security

-   Input validation
-   Environment configs
-   Password hashing
-   Role-based access (basic)

------------------------------------------------------------------------

## 12 Factor App

-   Env config
-   Stateless
-   Docker environment
-   Logs to stdout
-   Same dev/prod




### Grapana

```grafana
sum(rate(app_db_query_total[1m])) by (type)

sum(rate(app_http_requests_total[1m]))
```


make build 



