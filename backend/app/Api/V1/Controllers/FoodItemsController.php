<?php

namespace App\Api\V1\Controllers;

use JWTAuth;
use Validator;
use Config;
use App\FoodItems;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Exceptions\JWTException;
use Dingo\Api\Exception\ValidationHttpException;
use App\Http\Requests;

class FoodItemsController extends Controller
{
	use Helpers;

	public function index()
	{
		$currentUser = JWTAuth::parseToken()->authenticate();
		return $currentUser
		->fooditems()
		->orderBy('created_at', 'DESC')
		->get()
		->toArray();
	}

	public function store(Request $request)
	{
		$currentUser = JWTAuth::parseToken()->authenticate();

		$fooditem = new FoodItems;

		$fooditem->name = $request->get('name');
		$fooditem->price = $request->get('price');
		$fooditem->amountAvailable = $request->get('amountAvailable');

		if($currentUser->fooditems()->save($fooditem))
			return $this->response->created();
		else
			return $this->response->error('could_not_create_fooditem', 500);
	}

	public function show($id)
	{
		$currentUser = JWTAuth::parseToken()->authenticate();

		$fooditem = $currentUser->fooditems()->find($id);

		if(!$fooditem)
			throw new NotFoundHttpException; 

		return $fooditem;
	}

	public function update(Request $request, $id)
	{
		$currentUser = JWTAuth::parseToken()->authenticate();

		$fooditem = $currentUser->fooditems()->find($id);
		if(!$fooditem)
			throw new NotFoundHttpException;

		$fooditem->fill($request->all());

		if($fooditem->save())
			return $this->response->noContent();
		else
			return $this->response->error('could_not_update_fooditem', 500);
	}

	public function destroy($id)
	{
		$currentUser = JWTAuth::parseToken()->authenticate();

		$fooditem = $currentUser->fooditems()->find($id);

		if(!$fooditem)
			throw new NotFoundHttpException;

		if($fooditem->delete())
			return $this->response->noContent();
		else
			return $this->response->error('could_not_delete_fooditem', 500);
	}
}
