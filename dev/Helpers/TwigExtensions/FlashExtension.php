<?php
/**
 * Created by PhpStorm.
 * User: Ludwig
 * Date: 22/12/2017
 * Time: 08:12
 */

namespace App\Helpers\TwigExtensions;


use Twig_Extension;
use Twig_SimpleFunction;

class FlashExtension extends Twig_Extension {
    protected $flash;

    public function __construct(\Slim\Flash\Messages $flash) {
        $this->flash = $flash;
    }

    public function getFunctions() {
        return [
            new Twig_SimpleFunction("flash", [$this, "getMessage"]),
            new Twig_SimpleFunction("flash_all", [$this, "getMessages"])
        ];
    }

    public function getMessage(string $key) : ?string{
        return $this->flash->getFirstMessage($key);
    }

    public function getMessages(string $key) : array{
        return $this->flash->getMessage($key);
    }
}