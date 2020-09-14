<?php

namespace LignumSoftware\LignumMercadoPago;

use Illuminate\Support\ServiceProvider;
use App\Helper\MP;

class LignumMercadoPagoServiceProvider extends ServiceProvider
{
	//protected $access_token;

	public function boot()
	{
		$this->publishes([__DIR__.'/../config/mercadopago.php' => config_path('mercadopago.php')]);
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