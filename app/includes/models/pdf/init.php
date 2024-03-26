<?php

class ThesisProcess
{

    public function process_frontespizio($file_name, $dir)
    {
        $image = new Imagick($dir . "/" . $file_name . '[0]');
        $image->setImageFormat('jpg');
        $image->mergeImageLayers(Imagick::LAYERMETHOD_FLATTEN);
        $image->setImageAlphaChannel(Imagick::ALPHACHANNEL_REMOVE);
        $image->writeImage($dir . "/frontespizio.jpg");
    }
}
