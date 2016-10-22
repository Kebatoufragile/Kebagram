<?php

namespace App\Controllers;

use Psr\Log\LoggerInterface;

abstract class AbstractController{

    protected $view;
    protected $logger;

    function __construct($view){
        $this->view = $view;
    }
}

?>
