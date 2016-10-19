<?php

namespace controller;

abstract class AbstractController{

  public $requete;

  function __construct($r){
    $this->requete=$r;
  }
}

 ?>
