# Freepik - Country Checker API
## Setup
1. Clone repository
```
git clone https://github.com/Rumi-Aguirre/freepik-country-checker.git
```

2. Start application with `docker-compose`:
```
export UID && docker-compose up -d
```

3. Run tests:
```
docker-compose exec php-fpm /var/www/freepik/vendor/bin/phpunit /var/www/freepik/tests --configuration /var/www/freepik/phpunit.xml --do-not-cache-result --colors=always
```

## Validation
The application uses `cakephp/validation` for input validation.

`league/json-guard` is also used to validate that RapidAPI responses match with expected schema.

## OpenApi
This project comes with an implementation of OpenApi bassed on annotations. To regenerate the openapi.yaml run the following command:
```
composer openapi
```

The output file is compatible with any OpenApi parser. For example https://editor.swagger.io/