<?php

class ThesisProcess
{

    public function process_frontespizio($file_name)
    {
        $im = new Imagick($file_name . '[0]');
        $im->setImageFormat('jpg');
        header('Content-Type: image/jpeg');
        echo $im;
    }
}
