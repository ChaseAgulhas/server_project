<?php

namespace App\Api\V1\Controllers;

use JWTAuth;
use Validator;
use Config;
use App\Order;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Exceptions\JWTException;
use Dingo\Api\Exception\ValidationHttpException;
use App\Http\Requests;

class OrderController extends Controller
{
    use Helpers;

	public function index()
	{
		$currentUser = JWTAuth::parseToken()->authenticate();
		return $currentUser
		->orders()
		->orderBy('created_at', 'DESC')
		->get()
		->toArray();
	}

	public function store(Request $request)
	{
		$currentUser = JWTAuth::parseToken()->authenticate();

		$order = new Order;

		$order->products = $request->get('products');
		$order->comment = $request->get('comment');

		if($currentUser->products()->save($order))
			return $this->response->created();
		else
			return $this->response->error('could_not_create_order', 500);
	}

	public function show($id)
	{
		$currentUser = JWTAuth::parseToken()->authenticate();

		$order = $currentUser->orders()->find($id);

		if(!$order)
			throw new NotFoundHttpException; 

		return $order;
	}

	public function update(Request $request, $id)
	{
		$currentUser = JWTAuth::parseToken()->authenticate();

		$order = $currentUser->orders()->find($id);
		if(!$order)
			throw new NotFoundHttpException;

		$order->fill($request->all());

		if($order->save())
			return $this->response->noContent();
		else
			return $this->response->error('could_not_update_order', 500);
	}

	public function destroy($id)
	{
		$currentUser = JWTAuth::parseToken()->authenticate();

		$order = $currentUser->orders()->find($id);

		if(!$order)
			throw new NotFoundHttpException;

		if($order->delete())
			return $this->response->noContent();
		else
			return $this->response->error('could_not_delete_order', 500);
	}
}
