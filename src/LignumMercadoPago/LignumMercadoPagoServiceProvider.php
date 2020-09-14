<?php

namespace LignumMercadoPago;

use Illuminate\Support\ServiceProvider;
use LignumMercadoPago\Helper\MP;
use MercadoPago;

class LignumMercadoPagoServiceProvider extends ServiceProvider
{
	protected $access_token;

	public function boot()
	{
		$this->publishes([__DIR__.'/../config/mercadopago.php' => config_path('mercadopago.php')]);

		$this->access_token = config('mercadopago.access_token');

		$secret = $this->access_token;

		MercadoPago\SDK::setAccessToken($secret);
	}

	public function register()
	{
		//registramos un singleton porque lo vamos a usar como constructor
		//y despues llamar las funciones, o hay algo que modificar?

		$this->app->singleton('MP', function(){
			//return new MP($this->access_token);
			return new MP();
		});
	}
}