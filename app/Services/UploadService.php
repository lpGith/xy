<?php

declare(strict_types=1);

/**
 * Created by :phpstorm
 * User: qinghe
 * Date: 2022/9/4
 * Time: 13:55
 * File: UploadService.php
 */

namespace App\Services;


use Dflydev\ApacheMimeTypes\PhpRepository;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class UploadService
{
    /**
     * @var Filesystem
     */
    protected Filesystem $disk;

    /**
     * @var PhpRepository
     */
    protected PhpRepository $phpRepository;

    /**
     * UploadService constructor.
     *
     * @param PhpRepository $phpRepository
     */
    public function __construct(PhpRepository $phpRepository)
    {
        $this->disk = Storage::disk(config('blog.uploads.storage'));
        $this->phpRepository = $phpRepository;
    }

    /**
     * @param $request
     * @return array
     * @Time 2022/9/4 14:10
     * @author qinghe
     */
    public function uploadFile($request): array
    {
        $dir = '/' . trim(str_replace('\\', '/', $request->dir), '/') . '/';
        if (!$this->dirExists($dir)) {
            return ['status' => false, 'msg' => '目录不存在'];
        }

        $file = $request->file('file');
        $name = $request->name;

        $fileName = $name != '' ? $name : md5(time() . rand(0, 10000));
        $saveFile = $dir . $fileName . '.' . $file->getClientOriginalExtension();

        if ($this->disk->exists($saveFile)) {
            return ['status' => false, 'msg' => '文件名已存在或文件已存在'];
        }


        if ($this->disk->put($saveFile, File::get($file->getPathname()))) {
            $url = route('admin.upload.index', ['dir' => $dir]);
            return ['status' => true, 'url' => $url];
        }

        return ['status' => false, 'msg' => '上传失败'];
    }

    /**
     * @author qinghe
     * @Time 2022/9/4 14:00
     */
    public function disk(): Filesystem
    {
        return $this->disk;
    }

    /**
     * @param $dir
     * @return array
     * @Time 2022/9/4 14:07
     * @author qinghe
     */
    public function folderInfo($dir): array
    {
        $fileList = $this->fileInfo($dir);
        $dirList = $this->dirList($dir);

        return compact('fileList', 'dirList');
    }

    /**
     * @param $path
     * @return bool
     * @Time 2022/9/4 14:06
     * @author qinghe
     */
    public function dirExists($path): bool
    {
        if ($path != '') {
            return $this->disk->exists($path);
        }

        return true;
    }

    /**
     * @param $dir
     * @return array
     * @Time 2022/9/4 14:05
     * @author qinghe
     */
    public function dirList($dir): array
    {
        $list = $this->disk->directories($dir);

        $dirList = [];
        foreach ($list as $l) {
            $lArray = explode('/', str_replace('\\', '/', $l));
            $dirList[] = array_pop($lArray);
        }

        return $dirList;
    }

    /**
     * @param $dir
     * @return array
     * @Time 2022/9/4 14:07
     * @author qinghe
     */
    public function fileInfo($dir): array
    {
        $files = $this->disk->files($dir);
        $filesInfo = [];
        $webPath = config('blog.uploads.webPath');
        $host = url('/');

        if ($files) {
            foreach ($files as $file) {
                $temp = [];
                $temp['file_name'] = basename($file);
                $temp['mime_type'] = $this->getFileMimeType($file);
                $temp['size'] = $this->getFileSize($file);
                $temp['modified_date'] = $this->getLastModified($file);
                $temp['path'] = $host . $webPath . '/' . $file;

                $filesInfo[] = $temp;
            }
        }

        return $filesInfo;
    }

    /**
     * @param $path
     * @return string|null
     * @Time 2022/9/4 14:03
     * @author qinghe
     */
    public function getFileMimeType($path): ?string
    {
        return $this->phpRepository->findType(pathinfo($path, PATHINFO_EXTENSION));
    }

    /**
     * @param $path
     * @return int
     * @Time 2022/9/4 14:03
     * @author qinghe
     */
    public function getFileSize($path): int
    {
        return $this->disk->size($path);
    }

    /**
     * @param $path
     * @return false|string
     * @Time 2022/9/4 14:04
     * @author qinghe
     */
    public function getLastModified($path)
    {
        return date('Y-m-d H:i:s', $this->disk->lastModified($path));
    }
}
