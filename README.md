# Bs2 Empresas for Laravel

This is a package developed in Laravel 8, still under development (Any and all contributions are very welcome)

## Installation

You can install the package via composer, adding the code below to your composer.json

``` javascript
"repositories": [
        {
            "type": "git",
            "url": "https://github.com/GoyanDevelopers/laravel-bs2"
        }
]
```
Next publish the migration with:
``` bash
php artisan vendor:publish --provider="Goyan\Bs2\GoyanServiceProvider"
```
Run the migrate command to create the necessary table:

``` bash
php artisan migrate
```

Finally, run the event loop with the code below (Replace **{token}** with your refresh_token provided by **BS2**)

``` bash
php artisan goyan:bs2 --token="{token}"
```

## Licença
GNU GENERAL PUBLIC LICENSE
