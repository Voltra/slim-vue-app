<?php

namespace App\Helpers\TwigExtensions;


use Slim\Views\Twig;
use Twig_Extension;
use Twig_SimpleFunction;

class CsrfExtension extends Twig_Extension {
    protected $view;

    public function __construct(Twig $view){
        $this->view = $view;
    }

    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction("csrf_input_tag", [
                $this,
                "csrfInput"
            ])
        ];
    }

    public function csrfInput(){
        $csrfKey = $this->view["csrf_key"];
        $csrfToken = $this->view["csrf_token"];

        return "<input type='hidden' name='{$csrfKey}' value='{$csrfToken}'/>";
    }
}