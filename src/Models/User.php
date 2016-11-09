<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
  protected $table = "users";
  protected $primaryKey = "id";

  public static function getKebabs(){
    // recuperation des images
    $pictures =Pictures::all();
    $kebabslist = array();

    // recuperation des tags et des usernames
    foreach($pictures as $picture){
      $picture->username = User::where('id', 'like', $picture->AuthorKey)->first()->username;
      $kebabslist[] = array($picture, Tag::where("uid", "like", $picture->uId));
    }

    if(isset($_SESSION['userid']))
      $_SESSION['user'] = User::where("id", "like", $_SESSION['userid'])->first();

    return $kebabslist;
  }
}
