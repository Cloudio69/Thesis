<?php

class ThesisProcess
{
    public function process_frontespizio($file_name, $dir)
    {
        $image = new Imagick();

        $image->setResolution(300, 300);
        $image->readImage($dir . "/" . $file_name . '[0]');
        $image->scaleImage(1920, 1280, true);
        $image->setImageFormat('jpg');

        $image->mergeImageLayers(Imagick::LAYERMETHOD_FLATTEN);
        $image->setImageAlphaChannel(Imagick::ALPHACHANNEL_REMOVE);
        $image->writeImage($dir . "/frontespizio.jpg");
    }

    public static function genera_pagine($fileSorgente, $cartellaDestinazione, $num_pagina)
    {
        $image = new Imagick();
        $image->setResolution(300, 300);
        $image->readImage($fileSorgente . "[" . $num_pagina . ']');
        $image->scaleImage(1920, 1280, true);
        $image->setImageFormat('jpg');

        $image->mergeImageLayers(Imagick::LAYERMETHOD_FLATTEN);
        $image->setImageAlphaChannel(Imagick::ALPHACHANNEL_REMOVE);
        $image->writeImage($cartellaDestinazione . "/pagina-{$num_pagina}.jpg");
    }

    public static function get_num_pagine($fileSorgente)
    {
        $pdf = file_get_contents($fileSorgente);
        $num = preg_match_all("/\/Page\W/", $pdf, $dummy);
        return $num;
    }

    public static function genera_frontespizio($percorso, $r, $g, $b, $output)
    {
        self::colore_singolo($percorso, $output);
        self::rimuovi_sfondo($output, $output);
        self::colora_canale_alpha($output, $r, $g, $b, $output);
    }

    public static function rimuovi_sfondo($src, $dest)
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

    public static function colore_singolo($fileSorgente, $destinazione)
    {
        $imagick = new Imagick();
        $imagick->setResolution(300, 300);
        $imagick->readImage($fileSorgente);
        $imagick->scaleImage(1920, 1280, true);
        $imagick->quantizeImage(2, imagick::COLORSPACE_TRANSPARENT, 16, true, false);
        $imagick->writeImages($destinazione, false);
    }

    public static function colora_canale_alpha($inputFilePath, $red, $green, $blue, $outputFilePath)
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
