<?php

declare(strict_types=1);

/**
 * Created by :phpstorm
 * User: qinghe
 * Date: 2022/11/18
 * Time: 14:42
 * File: PagesController.php
 */

namespace App\Http\Controllers;


use Spatie\Sitemap\SitemapGenerator;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class PagesController extends Controller
{
    /**
     * @throws \Exception
     */
    public function sitemap(): BinaryFileResponse
    {
        $map = cache()->remember('site-map', 120, function () {
            $path = public_path('sitemap.xml');
            SitemapGenerator::create(config('app.url'))->writeToFile($path);
            return $path;
        });

        return response()->file($map);
    }
}
