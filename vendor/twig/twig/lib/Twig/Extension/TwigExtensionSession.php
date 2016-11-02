<?php

namespace AppBundle\Twig;

class TwigExtensionSession extends Twig_Extension implements Twig_Extension_GlobalsInterface
{
    public function getGlobals()
    {
        return array(
            'session' => $_SESSION
        );
    }

    public function getName()
    {
        return 'session';
    }

}