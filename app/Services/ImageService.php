<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

/**
 * Class ImageService
 * @package App\Services
 */
class ImageService
{

    /**
     * Get thumb img if exist
     *
     * @param string $ur_img
     * @return string
     */
    public static function getThumbImg(string $ur_img): string
    {
        $new_url_img = str_replace('media', "media/thumb", $ur_img);

        if(\App\Helpers\UrlExists::UrlExists($new_url_img) ) {
            return $new_url_img;
        } else {
            return $ur_img;
        }
    }


    /**
     *
     * Create a thumb img
     *
     * @param string $filename
     * @param int $height
     */
    public static function createThumb(string $filename, int $height = 270): void
    {

        ini_set('memory_limit', '2048M');
        set_time_limit(0);

        // Source
        $src = asset('storage/media/'.$filename);

        // Destination
        $dst = 'storage/media/thumb/'.$filename;

        // Get original image size and mime type
        list($orig_width, $orig_height, $type) = getimagesize($src);

        // Check the image format
        $old_image = match ($type) {
            IMAGETYPE_JPEG => imagecreatefromjpeg($src),
            IMAGETYPE_PNG => imagecreatefrompng($src),
            default => throw new \Exception('error format')
        };

        // Calculate new height and width
        $ratio = $orig_width / $orig_height;
        $width = $height * $ratio;

        ImageService::saveNewImg($type, $width, $height, $dst, $old_image, $orig_width, $orig_height);

    }

    /***
     *
     * from url
     * @param $filename
     * @param string $width
     */
    public static function compressImg(string $filename, string $width = "1500"): void
    {
        // Source
        $src = asset($filename);

        // Target
        $dst = $filename;

        // Get original image size and mime type
        [$orig_width, $orig_height, $type] = getimagesize($src);

        // Check the image format
        $old_image = match ($type) {
            IMAGETYPE_JPEG => imagecreatefromjpeg($src),
            IMAGETYPE_PNG => imagecreatefrompng($src),
            default => throw new \Exception('error format')
        };


        // Calculate new height based on the width and original ratio
        $ratio = $orig_height / $orig_width;
        $height = $width * $ratio;

        ImageService::saveNewImg($type, $width, $height, $dst, $old_image, $orig_width, $orig_height);
    }

    /**
     * Compress img
     *
     * @param string $filename
     * @param string $width
     */
    public static function compressImgFromFile(string $filename, string $width = "1500"): void
    {
        ini_set('memory_limit', '2048M');
        set_time_limit(0);

        // Source
        $src = public_path('storage/media/' . $filename);

        // Target
        $dst =public_path('storage/media/'. $filename);


        // Get original image size and mime type
        [$orig_width, $orig_height, $type] = getimagesize($src);

        // Check the image format
        $old_image = match ($type) {
            IMAGETYPE_JPEG => imagecreatefromjpeg($src),
            IMAGETYPE_PNG => imagecreatefrompng($src),
            default => throw new \Exception('error format')
        };


        // Calculate new height based on the width and original ratio
        $ratio = $orig_height / $orig_width;
        $height = round($width * $ratio);

        ImageService::saveNewImg($type, $width, $height, $dst, $old_image, $orig_width, $orig_height);
    }


    /**
     *
     * Add watermark
     *
     * @param string $url_orig
     * @throws \Exception
     */
    public static function addWaterMark(string $url_orig): void
    {
        $local_path = storage_path('app/public/media/' .$url_orig);

        $type = exif_imagetype($local_path);

        // Charge l'image originale
        $old_image = match ($type) {
            IMAGETYPE_JPEG => imagecreatefromjpeg($local_path),
            IMAGETYPE_PNG => imagecreatefrompng($local_path),
            default => throw new \Exception('error format')
        };


        // Obtient les dimensions de l'image originale
        $orig_width = imagesx($old_image);
        $orig_height = imagesy($old_image);

        // Crée une nouvelle image avec watermark
        $width = $orig_width;
        $height = $orig_height;
        $dst = $local_path;
        ImageService::saveNewImg($type, $width, $height, $dst, $old_image, $orig_width, $orig_height);

    }

    /**
     *
     * Save IMG
     *
     *
     * @param string $type
     * @param int $width
     * @param int $height
     * @param string $dst
     * @param string $old_image
     * @param int $orig_width
     * @param int $orig_height
     */
    public static function saveNewImg(string $type, int $width, int $height, string $dst, $old_image, int $orig_width, int $orig_height): void
    {

        $width = intval($width);
        $height = intval($height);

        $new_image = imagecreatetruecolor($width, $height);

        imagecopyresampled($new_image, $old_image, 0, 0, 0, 0, $width, $height, $orig_width, $orig_height);

        if (file_exists($dst)) {
            unlink($dst);
        }

        $signature = "EASY REUNION";

        // create filigrane txt
        $color = imagecolorallocate($new_image, 255, 255, 255);
        $font = realpath('fonts/Poppins/Poppins-Bold.ttf');

        $signature_size = max($width * 0.030, 30);

        // dimension text - position
        $bbox = imagettfbbox($signature_size, 0, $font, $signature);
        $text_width = $bbox[2] - $bbox[0];
        $text_height = $bbox[3] - $bbox[5];

        // position
        $position_x = $width - $text_width - 150;
        $position_y = $height - $text_height - 10;

        // mix
        imagettftext($new_image, $signature_size, 0, $position_x, $position_y, $color, $font, $signature);

        // Save
        switch ($type) {
            case IMAGETYPE_JPEG:
                imagejpeg($new_image, $dst, 50);
                break;
            case IMAGETYPE_PNG:
                imagepng($new_image, $dst, 50);
                break;
        }

        imagedestroy($new_image);
        imagedestroy($old_image);

    }

}
