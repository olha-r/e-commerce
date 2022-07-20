<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;

class TestController
{
    /**
     * @Route("/test", name="test")
     */
    public function test()
    {
        dd("It works");
    }

}