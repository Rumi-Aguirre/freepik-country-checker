# Freepik - Country Checker API
## Previous considerations
At the development moment the API required for receive country data returns a 403 forbidden.
I made a local implementation with some static responses, the following country codes are available:

- aut (Austria)
- chn (China)
- cod (Democratic Republic of the Congo)
- col (Colombia)
- dza (Algeria)
- est (Estonia)
- nor (Norway)
- rus (Russia)
- sjm (Svalbard and Jan Mayen)
- ita (Italy)

Another thing that I noticed it's the fact that in the PDF says that the Population Rule when the region is Asia the population should be over 80.000.00 but I think that maybe one zero is missing. Anyway I followed the PDF instruction

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

4. Check that app is runing on `http://localhost:8080` (should retrun an 404 since there is not implemented an index)

## Validation
The application uses `cakephp/validation` for input validation.

`league/json-guard` is also used to validate that RapidAPI responses match with expected schema.

## OpenApi
This project comes with an implementation of OpenApi bassed on annotations. To regenerate the openapi.yaml run the following command:
```
./vendor/bin/openapi --output openapi.yml src
```

The output file is compatible with any OpenApi parser. For example https://editor.swagger.io/

## Next steps
There is a lot of improvements that can be made but I consider that are out of the prupose of this technical test. Probably my next steps would be (at no specific order):

- Add environment variables for data like API Key
- Add CORS protection
- Add prometheus metrics
- Add test to infrastructure pieces like logger
- Add a cache layer to avoid getting the same countries from Api many times
- Add a changelog to track the changes following Semantic Versioning
- Etc. 
