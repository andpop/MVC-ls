<?php
namespace App\Core;

class View
{
    protected $loader;
    protected $twig;

    public function __construct()
    {
        $this->loader = new \Twig_Loader_Filesystem(APPLICATION_PATH.'app/views');
        $this->twig = new \Twig_Environment($this->loader);
    }
    public function twigRender($filename, array $data)
    {
        echo $this->twig->render($filename.".twig", $data);
    }
}
