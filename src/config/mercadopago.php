<?php

//Access token es el access token que te dan en la pagina de mercadolibre
//notification_url es la URL a la que se te notifica por webhook cuando cambie le estado del pago
//back_url_success es a donde lo devuelve cuando vuelve paga efectivamente en mercadopago
//back_url_failure es a donde lo devuelve cuando falla o expira el pago
//back_url_pending es a donde lo devuelve cuando elige un medio de pago no inmediato
return [
	'access_token' => env('MP_ACCESS_TOKEN', 'YourAcessToken'),
	'notification_url'     => env('MP_notification_url', 'https://YourNotificationPage.com/'),
	'back_url_success'     => env('MP_back_url_success', 'https://YourSuccessPage.com/'),
	'back_url_failure'     => env('MP_back_url_failure', 'https://YourFailurePage.com/'),
	'back_url_pending'     => env('MP_back_url_pending', 'https://YourPendingPage.com/')
];