<?php

class ThesisProcess
{

    public function process_frontespizio($file_name, $dir)
    {
        $image = new Imagick($dir . "/" . $file_name . '[0]');
        $image->setImageFormat('jpg');
        $image->setResolution(300, 300);
        $image->mergeImageLayers(Imagick::LAYERMETHOD_FLATTEN);
        $image->setImageAlphaChannel(Imagick::ALPHACHANNEL_REMOVE);
        $image->writeImage($dir . "/frontespizio.jpg");
    }

    public function genera_frontespizio($image_path, $start_color, $stop_color, $upload_dir)
    {
        $image = new Imagick();
        $image->readImage($upload_dir . "/" . $image_path . '[0]');
        $image->setResolution(300, 300);
        $image->transparentPaintImage((new ImagickPixel('white')), 0, 0, false);
        $image->modulateImage(0, 0, 100);
        $image->setImageFormat('png');
        $image->writeImage($upload_dir . "/frontespizio_generato.png");

        $image->clear();
        $image->destroy();
    }
}
