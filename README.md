# INSTALO DEPURADOR DE CONSULTAS
Vamos a packagist.org y buscamos debug
`composer require barryvdh/laravel-debugbar`
Despues de instalar  vamos a ___config/app.php__ y pegamos en los provider `Barryvdh\Debugbar\ServiceProvider::class,`
y en __aliases__ `'Debugbar' => Barryvdh\Debugbar\Facade::class,`

Ahora hacemos la publicacion `php artisan vendor:publish --provider="Barryvdh\Debugbar\ServiceProvider"`

Si todo salio bien en __config/__ se nos crea __debugbar__

# INSTALO HTML COLLECTIVE
`composer require laravelcollective/html`