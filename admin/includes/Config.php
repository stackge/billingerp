<?php

namespace App;

class Config
{
    public static function baseUrl()
    {
        return rtrim(dirname(dirname($_SERVER['SCRIPT_NAME'])), '/');
    }

    public static function basePath()
    {
        return realpath(__DIR__ . '/../../');
    }

    //ფოლდერების ლოკაციების განსაზღვრა
    public static function dist(string $path): string {
        return '/admin/dist/' . ltrim($path, '/');
    }
    
    public static function libs(string $path): string {
        return '/admin/libs/' . ltrim($path, '/');
    }
    
    public static function preview(string $path): string {
        return '/admin/preview/' . ltrim($path, '/');
    }

    public static function static(string $path): string {
        return '/admin/static/' . ltrim($path, '/');
    }

    public static function route(string $relativePath, array $query = []): string
    {
        // თუ მიწოდებული ბმული აბსოლუტურია (იწყება http-ით ან /-ით), დავაბრუნოთ ისე
        if (strpos($relativePath, 'http') === 0 || strpos($relativePath, '/') === 0) {
            return $relativePath;
        }
        
        $url = '/admin/' . ltrim($relativePath, '/');
        
        if (!empty($query)) {
            $url .= (strpos($url, '?') !== false ? '&' : '?') . http_build_query($query);
        }
    
        return $url;
    }

    public static function includePath($file)
    {
        return self::basePath() . '/admin/includes/' . $file;
    }
}

