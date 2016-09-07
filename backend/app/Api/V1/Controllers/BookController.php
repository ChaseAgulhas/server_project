<?php

namespace App\Api\V1\Controllers;

use JWTAuth;
use Validator;
use Config;
use App\Book;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Exceptions\JWTException;
use Dingo\Api\Exception\ValidationHttpException;
use App\Http\Requests;


class BookController extends Controller
{
  use Helpers;

  public function index()
  {
   $currentUser = JWTAuth::parseToken()->authenticate();
   return $currentUser
   ->books()
   ->orderBy('created_at', 'DESC')
   ->get()
   ->toArray();
 }

 public function store(Request $request)
 {
   $currentUser = JWTAuth::parseToken()->authenticate();

   $book = new Book;

   $book->title = $request->get('title');
   $book->author_name = $request->get('author_name');
   $book->pages_count = $request->get('pages_count');

   if($currentUser->books()->save($book))
     return $this->response->created();
   else
     return $this->response->error('could_not_create_book', 500);
 }

 public function show($id)
 {
  $currentUser = JWTAuth::parseToken()->authenticate();

  $book = $currentUser->books()->find($id);

  if(!$book)
    throw new NotFoundHttpException; 

  return $book;
}

public function update(Request $request, $id)
{
  $currentUser = JWTAuth::parseToken()->authenticate();

  $book = $currentUser->books()->find($id);
  if(!$book)
    throw new NotFoundHttpException;

  $book->fill($request->all());

  if($book->save())
    return $this->response->noContent();
  else
    return $this->response->error('could_not_update_book', 500);
}

public function destroy($id)
{
  $currentUser = JWTAuth::parseToken()->authenticate();

  $book = $currentUser->books()->find($id);

  if(!$book)
    throw new NotFoundHttpException;

  if($book->delete())
    return $this->response->noContent();
  else
    return $this->response->error('could_not_delete_book', 500);
}
}
