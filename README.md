# MercadoPago-LignumSoftware-PHP-Laravel
Package to communicate with the MercadoPago SDK for PHP Laravel

Este paquete es un contenedor del SDK de mercadopago, para mas informacion en como utilizar el SDK dirigirse a su respectivo [git](https://github.com/mercadopago/dx-php)

* [Instalación](#install)
* [Configuración](#configuration)
* [Como utilizar](#how-to)

Readme basado en el de [santigraviano](https://github.com/santigraviano/laravel-mercadopago/blob/master/README.md)

<a name="install"></a>
### Instalación

`composer require lignumsoftware/mercadopago`

Si tu version de laravel es menor a 5.4: dentro de `config/app.php` agregar los siguientes Provider y Alias

Provider

```php
'providers' => [
  LignumSoftware\LignumMercadoPago\LignumMercadoPagoServiceProvider::class,
  /*
   * If your laravel version doesnt' have autodiscover (V 5.4) then you need to add this manually
   */
],
```

Alias

```php
'aliases' => [
  'MP' => LignumSoftware\LignumMercadoPago\Facades\MP::class,
],
```

<a name="configuration"></a>
### Configuración

Antes de configurar el access_token, ejecutar el siguiente comando: 

`php artisan vendor:publish`

Despues de haber ejecutado el comando, ir al archivo `.env` y agregar el campo `MP_ACCESS_TOKEN` de tu aplicacion de MercadoPago. (Dependiendo de tu pais deberas acceder al panel de credenciales para obtenerlo - https://www.mercadopago.com.ar/developers/panel/credentials)

Si no deseas usar el archivo `.env`, ir a `config/mercadopago.php` y agregar tus datos de aplicación correspondientes.

```php
return [
    // Access token es el access token que te dan en la pagina de mercadolibre
    // notification_url es la URL a la que se te notifica por webhook cuando cambie le estado del pago
    // back_url_success es a donde lo devuelve cuando vuelve paga efectivamente en mercadopago
    // back_url_failure es a donde lo devuelve cuando falla o expira el pago
    // back_url_pending es a donde lo devuelve cuando elige un medio de pago no inmediato
	'access_token' => env('MP_ACCESS_TOKEN', 'YourAcessToken'),
	'notification_url' => env('MP_notification_url', 'https://YourNotificationPage.com/'),
	'back_url_success' => env('MP_back_url_success', 'https://YourSuccessPage.com/'),
	'back_url_failure' => env('MP_back_url_failure', 'https://YourFailurePage.com/'),
	'back_url_pending' => env('MP_back_url_pending', 'https://YourPendingPage.com/')
];
```

<a name="how-to"></a>
### Como utilizar

Hay dos funciones posibles, una que utilizara los parametros del archivo config/mercadopago.php y otra que funcionara con los parametros custom para hacer la comunicacion.

En el archivo MP de la carpeta HELPER podras encontrar que pasar en cada parametro.

Para utilizar la funcion createVenta deberas enviar los siguientes parametros:
```php
    /**
     * expiration_date_from es Carbon::now()->toIso8601String() y expiration_date_to = Carbon::now()->addHour()->toIso8601String() lo que significa que expira en una hora, si se desea customizar estos (y otros) parametros usar la funcion  createVentaCustomRedirect
     * 
     * @param  array[] $uitems es un array de arrays que contiene en cada item[0] = Titulo del articulo, item[1] = cantidad del articulo, item[2] = precio unitario
     * @param  array $cliente es un array con los datos del cliente en donde $cliente[0] = nombre, $cliente[1] = apellido, $cliente[2] = email , $cliente[3] = dni
     * @param  int  $carritoID
     * @return MercadoPago\Preference
     */
    function createVenta($uitems, $cliente, $carritoID){
        //code
    }

```

Para utilizar la funcion createVentaCustomRedirect deberas enviar los siguientes parametros:

```php
    /**
     * @param  array[] $uitems es un array de arrays que contiene en cada item[0] = Titulo del articulo, item[1] = cantidad del articulo, item[2] = precio unitario
     * @param  array $cliente es un array con los datos del cliente en donde $cliente[0] = nombre, $cliente[1] = apellido, $cliente[2] = email , $cliente[3] = dni
     * @param  int  $carritoID
     * @param  string  $notification_url es la URL a la que se te notifica por webhook cuando cambie le estado del pago
     * @param  string  $back_url_success es a donde lo devuelve cuando vuelve paga efectivamente en mercadopago
     * @param  string  $back_url_failure es a donde lo devuelve cuando falla o expira el pago
     * @param  string  $back_url_pending es a donde lo devuelve cuando elige un medio de pago no inmediato
     * @param  string  $expiration_date_from desde - Vencimiento en formato Iso8601 para ambos expiration date es recomendable usar el parse de carbon por ejemplo "Carbon::now()->toIso8601String()"
     * @param  string  $expiration_date_to hasta - Vencimiento en formato Iso8601
     * @return MercadoPago\Preference
     */
    function createVentaCustomRedirect($uitems, $cliente, $carritoID, $notification_url, $back_url_success, $back_url_failure, $back_url_pending, $expiration_date_from, $expiration_date_to){
        //code
    }
```