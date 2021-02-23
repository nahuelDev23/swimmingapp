# INSTALO DEPURADOR DE CONSULTAS
Vamos a packagist.org y buscamos debug
`composer require barryvdh/laravel-debugbar`
Despues de instalar  vamos a ___config/app.php__ y pegamos en los provider `Barryvdh\Debugbar\ServiceProvider::class,`
y en __aliases__ `'Debugbar' => Barryvdh\Debugbar\Facade::class,`

Ahora hacemos la publicacion `php artisan vendor:publish --provider="Barryvdh\Debugbar\ServiceProvider"`

Si todo salio bien en __config/__ se nos crea __debugbar__

# INSTALO HTML COLLECTIVE
`composer require laravelcollective/html`

# instalo composer require maatwebsite/excel
para poder importar y exportar desde excel a mysql

vamos a php ini y descomentamos extencion=gd
composer require phpoffice/phpspreadsheet
require maatwebsite/excel
https://docs.laravel-excel.com/3.0/getting-started/installation.html
https://www.webslesson.info/2019/02/import-excel-file-in-laravel.html

# rutas seguras 
https://www.laraveltip.com/hace-tus-rutas-mas-seguras-con-este-tip/

https://www.laraveltip.com/accessors-y-appends-dos-caracteristicas-poderosas-de-eloquent/

https://www.laraveltip.com/mejora-el-codigo-de-tus-controladores-con-clases-responsables/