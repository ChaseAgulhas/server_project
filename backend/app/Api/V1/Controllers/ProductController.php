<?php

namespace App\Api\V1\Controllers;

use JWTAuth;
use Validator;
use Config;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Exceptions\JWTException;
use Dingo\Api\Exception\ValidationHttpException;
use App\Http\Requests;

class ProductController extends Controller
{
	use Helpers;

	public function index()
	{
		$currentUser = JWTAuth::parseToken()->authenticate();
		return $currentUser
		->products()
		->orderBy('created_at', 'DESC')
		->get()
		->toArray();
	}

	public function store(Request $request)
	{
		$currentUser = JWTAuth::parseToken()->authenticate();

		$product = new Product;

		$product->name = $request->get('name');
		$product->category = $request->get('category');
		$product->optional = $request->get('optional');
		$product->optional_two = $request->get('optional_two');
		$product->price = $request->get('price');

		if($currentUser->products()->save($product))
			return $this->response->created();
		else
			return $this->response->error('could_not_create_product', 500);
	}

	public function show($id)
	{
		$currentUser = JWTAuth::parseToken()->authenticate();

		$product = $currentUser->products()->find($id);

		if(!$product)
			throw new NotFoundHttpException; 

		return $product;
	}

	public function update(Request $request, $id)
	{
		$currentUser = JWTAuth::parseToken()->authenticate();

		$product = $currentUser->products()->find($id);
		if(!$product)
			throw new NotFoundHttpException;

		$product->fill($request->all());

		if($product->save())
			return $this->response->noContent();
		else
			return $this->response->error('could_not_update_product', 500);
	}

	public function destroy($id)
	{
		$currentUser = JWTAuth::parseToken()->authenticate();

		$product = $currentUser->products()->find($id);

		if(!$product)
			throw new NotFoundHttpException;

		if($product->delete())
			return $this->response->noContent();
		else
			return $this->response->error('could_not_delete_product', 500);
	}
}
