<?php

namespace Core\Helpers;

use Core\Facedas\Alerts;
use Core\Facedas\Lang;

class File
{
    private static function path($path)
    {
        $path = public_path($path);
        @mkdir($path, 0777, true);
        return $path;
    }

    private static function createName($name)
    {
        $ext = @end(explode(".", $name));
        return uniqid('file-', true) . ".$ext";
    }

    private static function removePublic($name)
    {
        return str_replace(public_path(), '', $name);
    }

    public static function save($path, $file)
    {
        $uploadName = self::path($path) . "/" . self::createName(end(explode('/', $file)));
        file_put_contents($uploadName, file_get_contents($file));
        return self::removePublic($uploadName);
    }

    public static function upload($path, $file, $options = [])
    {
        $path = self::path($path);
        $name = $file['name'];
        $error = 0;

        if (isset($options['accept'])) {
            $ext = @end(explode('.', $name));
            if (!in_array($ext, $options['accept'])) {
                $error++;
                Alerts::danger(Lang::get('errors.file.type', ['file_types' => implode(', ', $options['accept'])]));
            }
        }

        if (isset($options['size']) && is_numeric($options['size']))
            if ($file['size'] > $options['size']) {
                $error++;
                Alerts::danger(Lang::get('errors.file.size', ['current-size' => human_filesize($file['size']), 'accept-size' => human_filesize($options['size'])]));
            }

        if ($error) return false;

        $uploadName = "$path/" . self::createName($name);
        if (move_uploaded_file($file['tmp_name'], $uploadName)) return self::removePublic($uploadName);
        return false;
    }

    public static function resizeImage($file, $width = 50, $height = 50)
    {
        $file = public_path($file);
        if (!is_file($file)) return false;

        // Yeni boyutları hesaplayalım
        list($image_width, $image_height) = getimagesize($file);

        // Görüntüyü örnekleyelim
        $target = imagecreatetruecolor($width, $height);
        $source = imagecreatefromjpeg($file);
        imagecopyresampled($target, $source, 0, 0, 0, 0, $width, $height, $image_width, $image_height);

        // Görüntüyü çıktılayalım
        imagejpeg($target, $file, 100);

        return self::removePublic($file);
    }
}
