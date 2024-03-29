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
    /**
     *   public function genera_frontespizio($image_path, $upload_dir, $hex = "#ffffff")
     *   {
     *       $image = new Imagick();
     *       $image->readImage($upload_dir . "/" . $image_path . '[0]');
     *       $image->setResolution(300, 300);
     *       $image->transparentPaintImage((new ImagickPixel('white')), 0, 0, false);
     *
     *       $image->setImageAlphaChannel(Imagick::ALPHACHANNEL_EXTRACT);
     *       $image->setImageBackgroundColor($hex);
     *       $image->setImageAlphaChannel(Imagick::ALPHACHANNEL_SHAPE);
     *
     *       $image->writeImage($upload_dir . "/frontespizio_generato.png");
     *
     *       $image->clear();
     *       $image->destroy();
     *    }
     */


    public static function genera_frontespizio($percorso, $r, $g, $b, $output)
    {
        self::coloreSingolo($percorso, $output);
        self::rimuoviSfondo($output, $output);
        self::coloraCanaleAlpha($output, $r, $g, $b, $output);
    }

    public static function rimuoviSfondo($src, $dest)
    {
        $immagine = imagecreatefrompng($src);
        $larghezza = imagesx($immagine);
        $altezza = imagesy($immagine);

        $nuovaImmagine = imagecreatetruecolor($larghezza, $altezza);
        imagesavealpha($nuovaImmagine, true);
        $rgb = imagecolorallocatealpha($nuovaImmagine, 0, 0, 0, 127);
        imagefill($nuovaImmagine, 0, 0, $rgb);
        $colore = imagecolorat($immagine, $larghezza - 1, 1);

        for ($x = 0; $x < $larghezza; $x++) {
            for ($y = 0; $y < $altezza; $y++) {
                $c = imagecolorat($immagine, $x, $y);
                if ($colore != $c) {
                    imagesetpixel($nuovaImmagine, $x, $y, $c);
                }
            }
        }

        imagepng($nuovaImmagine, $dest);
        imagedestroy($nuovaImmagine);
        imagedestroy($immagine);
    }

    public static function coloreSingolo($fileSorgente, $destinazione)
    {
        $imagick = new Imagick();
        $imagick->readImage($fileSorgente);
        $imagick->quantizeImage(2, imagick::COLORSPACE_TRANSPARENT, 16, true, false);
        $imagick->writeImages($destinazione, false);
    }

    public static function coloraCanaleAlpha($inputFilePath, $red, $green, $blue, $outputFilePath)
    {
        $immagineSorgente = imagecreatefrompng($inputFilePath);
        $immagineDestinazione = imagecreatefrompng($inputFilePath);
        $larghezza = imagesx($immagineSorgente);
        $altezza = imagesy($immagineSorgente);
        imagefill($immagineDestinazione, 0, 0, IMG_COLOR_TRANSPARENT);
        imagesavealpha($immagineDestinazione, true);
        imagealphablending($immagineDestinazione, true);

        for ($x = 0; $x < $larghezza; $x++) {
            for ($y = 0; $y < $altezza; $y++) {
                $rgb = imagecolorat($immagineSorgente, $x, $y);
                $coloreRGBVecchio = imagecolorsforindex($immagineSorgente, $rgb);
                $alpha = $coloreRGBVecchio["alpha"];
                $coloreNuovo = imagecolorallocatealpha($immagineSorgente, $red, $green, $blue, $alpha);

                if (false !== $coloreNuovo) {
                    imagesetpixel($immagineDestinazione, $x, $y, $coloreNuovo);
                }
            }
        }

        imagepng($immagineDestinazione, $outputFilePath);
        imagedestroy($immagineDestinazione);
        imagedestroy($immagineSorgente);
    }
}
