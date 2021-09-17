# Bs2 Empresas for Laravel

This is a package developed in Laravel 8, still under development (Any and all contributions are very welcome)
Go to <https://devs.bs2.com/> for more technical details.

## Installation

You can install the package via composer

``` bash
composer require goyan/laravel-bs2
```
Next publish the migration with:
``` bash
php artisan vendor:publish --provider="Goyan\Bs2\Bs2ServiceProvider"
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
