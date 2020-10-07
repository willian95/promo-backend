<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Freshwork\Transbank\WebpayNormal;
use Freshwork\Transbank\WebpayPatPass;
use Freshwork\Transbank\RedirectorHelper;

class CheckoutController extends Controller
{
    
    public function initTransaction(WebpayNormal $webpayNormal)
	{
		
		$webpayNormal->addTransactionDetail(1500, 'order-' . rand(1000, 9999));  
		$response = $webpayNormal->initTransaction(route('checkout.webpay.response'), route('checkout.webpay.finish'), null, 'TR_NORMAL_WS', null, null); 
		// Probablemente también quieras crear una orden o transacción en tu base de datos y guardar el token ahí.

		return RedirectorHelper::redirectHTML($response->url, $response->token);
    }
    
    public function response(WebpayPatPass $webpayPatPass)  
	{  
		$result = $webpayPatPass->getTransactionResult(); 
		session(['response' => $result]);
		dump($result, session("response"));
		$webpayPatPass->acknowledgeTransaction();

		// Revisar si la transacción fue exitosa ($result->detailOutput->responseCode === 0) o fallida para guardar ese resultado en tu base de datos. 
		//return RedirectorHelper::redirectBackNormal($result->urlRedirection);
		return RedirectorHelper::redirectBackNormal($result->urlRedirection);  
	}

	public function finish()  
	{

		

		dd($_POST, session('response'));  
		// Acá buscar la transacción en tu base de datos y ver si fue exitosa o fallida, para mostrar el mensaje de gracias o de error según corresponda
	}

}
