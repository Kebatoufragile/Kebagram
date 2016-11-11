<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = "users";
    protected $primaryKey = "id";

    public static function getKebabs()
    {
        // recuperation des images
        $pictures = Pictures::orderBy('uId', 'DESC')->get();
        $kebabslist = array();

        // recuperation des tags et des usernames
        foreach ($pictures as $picture) {
            $picture->username = User::where('id', 'like', $picture->AuthorKey)->first()->username;
            $kebabslist[] = array($picture, Tag::where("pictureId", "like", $picture->uId)->get());
        }

        if (isset($_SESSION['userid'])) {
            $_SESSION['user'] = User::where("id", "like", $_SESSION['userid'])->first();
        }

        return $kebabslist;
    }


    public static function getKebabsWithTag($search)
    {
        $tags = Tag::where('Tag', 'like', $search)->get();

        $kebabs = array();

        $pictures = array();

        foreach ($tags as $tag){
            $p = Pictures::orderBy('uId', 'DESC')->where('uId', 'like', $tag->pictureID)->get();
            foreach($p as $picture){
                $picture->username = User::where('id', 'like', $picture->AuthorKey)->first()->username;
                $pictures[] = $picture;
            }
        }

        $pictures = array_reverse(array_unique($pictures));

        foreach($pictures as $picture)
            $kebabs[] = array($picture, Tag::where("pictureId", "like", $picture->uId)->get());

        return $kebabs;

    }
}
