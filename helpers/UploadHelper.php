<?php
/**
 * Created by PhpStorm.
 * User: mariusngaboyamahina
 * Date: 10/26/18
 * Time: 12:48 PM
 */

namespace app\helpers;

use claviska\SimpleImage;
use Imagine\Gd\Imagine;
use thiagoalessio\TesseractOCR\TesseractOCR;
use Yii;
use yii\helpers\FileHelper;
use yii\base\ErrorException;

class UploadHelper
{

    public static function upload($uploaded_file, $model, $file_attribute, $file_name, $file_dir)
    {
        try {

            $file_path = $file_dir . $file_name;

            FileHelper::createDirectory($file_dir);
            if ($uploaded_file) { //&& $model->validate()
                if ($uploaded_file->saveAs($file_path)) {

                    self::checkImage($file_dir, $file_name);

                    $model->$file_attribute = $file_name;
                    $model->save();
                    return true;
                }
            } else {
                return false;
            }
        } catch (\Exception $e) {

        }
    }

    public static function getImageLocationInfo($image_path)
    {
        Yii::warning('image_path : ' . $image_path);

        try {
            $image = new SimpleImage($image_path);
            $exif = $image->getExif();

            Yii::warning('exif: ' . print_r($exif, true));

            if (!empty($exif)) {
                //get location of image
                $image_location = self::get_image_location($image_path);

                //latitude & longitude
                $imgLat = $image_location['latitude'];
                $imgLng = $image_location['longitude'];
                Yii::warning('image_location: ' . print_r($image_location, true));
                return $image_location;
            }

        } catch (\Exception $err) {
            Yii::$app->getSession()->setFlash("danger", 'getImageLocationInfo: ' . $err->getMessage());
        }
    }

    /**
     * @param $image_path
     * @return string
     */
    public static function getReadImage($image_path)
    {
        try {
            //$path = getenv('PATH');
            //putenv("PATH=$path:C:\Program Files (x86)\Tesseract-OCR");
            $ocr = new TesseractOCR();
            $ocr->image($image_path);
            $ocr->executable("/usr/local/bin/tesseract");
            $text = $ocr->run();
            //$text = getenv('PATH');;
            Yii::warning('ocr text: ' . $text);
            return $text;
        } catch (ErrorException $e) {
            Yii::$app->session->setFlash("danger", Yii::t('app', $e));
        }

    }

    /**
     * get_image_location
     * Returns an array of latitude and longitude from the Image file
     * @param $image file path
     * @return multitype:array|boolean
     */
    private static function get_image_location($image = '')
    {
        $exif = exif_read_data($image, 0, true);
        if ($exif && isset($exif['GPS'])) {
            $GPSLatitudeRef = $exif['GPS']['GPSLatitudeRef'];
            $GPSLatitude = $exif['GPS']['GPSLatitude'];
            $GPSLongitudeRef = $exif['GPS']['GPSLongitudeRef'];
            $GPSLongitude = $exif['GPS']['GPSLongitude'];

            $lat_degrees = count($GPSLatitude) > 0 ? self::gps2Num($GPSLatitude[0]) : 0;
            $lat_minutes = count($GPSLatitude) > 1 ? self::gps2Num($GPSLatitude[1]) : 0;
            $lat_seconds = count($GPSLatitude) > 2 ? self::gps2Num($GPSLatitude[2]) : 0;

            $lon_degrees = count($GPSLongitude) > 0 ? self::gps2Num($GPSLongitude[0]) : 0;
            $lon_minutes = count($GPSLongitude) > 1 ? self::gps2Num($GPSLongitude[1]) : 0;
            $lon_seconds = count($GPSLongitude) > 2 ? self::gps2Num($GPSLongitude[2]) : 0;

            $lat_direction = ($GPSLatitudeRef == 'W' or $GPSLatitudeRef == 'S') ? -1 : 1;
            $lon_direction = ($GPSLongitudeRef == 'W' or $GPSLongitudeRef == 'S') ? -1 : 1;

            $latitude = $lat_direction * ($lat_degrees + ($lat_minutes / 60) + ($lat_seconds / (60 * 60)));
            $longitude = $lon_direction * ($lon_degrees + ($lon_minutes / 60) + ($lon_seconds / (60 * 60)));

            return array('latitude' => $latitude, 'longitude' => $longitude);
        } else {
            return false;
        }
    }

    /**
     * @param $coordPart
     * @return float|int
     * The gps2Num() is a helper function, used in get_image_location()
     * function to convert GPS coord part in float val.
     */
    private static function gps2Num($coordPart)
    {
        $parts = explode('/', $coordPart);
        if (count($parts) <= 0)
            return 0;
        if (count($parts) == 1)
            return $parts[0];
        return floatval($parts[0]) / floatval($parts[1]);
    }


    public static function checkImage($file_dir, $file_name)
    {
        $image_file = $file_dir . $file_name;
        try {
            $image = new SimpleImage($image_file);

            $width = $image->getWidth();
            $height = $image->getHeight();

            Yii::warning('width : ' . $width);
            Yii::warning('height : ' . $height);

            $min_width = 100;
            $max_width = 512;

            if ($width > $min_width) {
                $image->fromFile($image_file)->resize($max_width)->toFile($file_dir . 'new_'. $file_name);
                return true;
            }

            if ($width < $min_width) {
                Yii::$app->getSession()->setFlash("fail", 'The dimensions of this image are too small!');
                return false;
            }

        } catch (\Exception $err) {
            Yii::$app->getSession()->setFlash("danger", 'checkImage: ' . $err->getMessage());
        }
    }
}