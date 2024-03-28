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

    public function genera_frontespizio($image_path, $upload_dir, $hex = "#ffffff")
    {
        $image = new Imagick();
        $image->readImage($upload_dir . "/" . $image_path . '[0]');
        $image->setResolution(300, 300);
        $image->transparentPaintImage((new ImagickPixel('white')), 0, 0, false);

        $image->setImageAlphaChannel(Imagick::ALPHACHANNEL_EXTRACT);
        $image->setImageBackgroundColor($hex);
        $image->setImageAlphaChannel(Imagick::ALPHACHANNEL_SHAPE);

        $image->writeImage($upload_dir . "/frontespizio_generato.png");

        $image->clear();
        $image->destroy();
    }
}
