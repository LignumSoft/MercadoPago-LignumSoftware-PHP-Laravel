<?php

namespace LignumMercadoPago\Helper;

use MercadoPago;
use Carbon\Carbon;

class MP {
    // ya no le paso el acess token porque lo seteo en el boot
    //private $token;

    /**
     * expiration_date_from es Carbon::now()->toIso8601String() y expiration_date_to = Carbon::now()->addHour()->toIso8601String() lo que significa que expira en una hora, si se desea customizar estos (y otros) parametros usar la funcion  createVentaCustomRedirect
     * 
     * @param  array[] $uitems es un array de arrays que contiene en cada item[0] = Titulo del articulo, item[1] = cantidad del articulo, item[2] = precio unitario
     * @param  array $cliente es un array con los datos del cliente en donde $cliente[0] = nombre, $cliente[1] = apellido, $cliente[2] = email , $cliente[3] = dni
     * @param  int  $carritoID
     * @return MercadoPago\Preference
     */
    function createVenta($uitems, $cliente, $carritoID){
        
        // ya no le paso el acess token porque lo seteo en el boot
        //MercadoPago\SDK::setAccessToken("");

        // Create a preference object
        $preference = new MercadoPago\Preference();

        $items = [];

        $i = 1;
        foreach($uitems as $ui){
            $item = new MercadoPago\Item();
            $item->id = $i++;
            $item->title = $ui[0];
            $item->quantity = $ui[1];
            $item->currency_id = 'ARS';
            $item->unit_price = $ui[2];

            array_push($items, $item);
        }

        $payer = new MercadoPago\Payer();
        $payer->name = $cliente[0];
        $payer->surname = $cliente[1];
        $payer->email = $cliente[2];

        $payer->identification = array(
            "type" => "DNI",
            "number" => $cliente[3]
        );

        $preference->payer = $payer;

        $preference->items = $items;
        $preference->external_reference = $carritoID;

        $preference->notification_url = config('mercadopago.notification_url');
        $preference->back_urls = [
                "success" => config('mercadopago.back_url_success'),
                "failure" => config('mercadopago.back_url_failure'),
                "pending" => config('mercadopago.back_url_pending')
            ];

        $preference->expires = true;
        $preference->expiration_date_from = Carbon::now()->toIso8601String();
        $preference->expiration_date_to = Carbon::now()->addHour()->toIso8601String();

        $preference->save();

        return($preference);
    }

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
        
        // ya no le paso el acess token porque lo seteo en el boot
        //MercadoPago\SDK::setAccessToken("");

        // Create a preference object
        $preference = new MercadoPago\Preference();

        $items = [];

        $i = 1;
        foreach($uitems as $ui){
            $item = new MercadoPago\Item();
            $item->id = $i++;
            $item->title = $ui[0];
            $item->quantity = $ui[1];
            $item->currency_id = 'ARS';
            $item->unit_price = $ui[2];

            array_push($items, $item);
        }

        $payer = new MercadoPago\Payer();
        $payer->name = $cliente[0];
        $payer->surname = $cliente[1];
        $payer->email = $cliente[2];

        $payer->identification = array(
            "type" => "DNI",
            "number" => $cliente[3]
        );

        $preference->payer = $payer;

        $preference->items = $items;
        $preference->external_reference = $carritoID;

        $preference->notification_url = $notification_url;
        $preference->back_urls = [
                "success" => $back_url_success,
                "failure" => $back_url_failure,
                "pending" => $back_url_pending
            ];

        $preference->expires = true;
        $preference->expiration_date_from = $expiration_date_from;
        $preference->expiration_date_to = $expiration_date_to;

        $preference->save();

        return($preference);
    }

}