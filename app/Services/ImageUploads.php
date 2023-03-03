<?php

declare(strict_types=1);

/**
 * Created by :phpstorm
 * User: qinghe
 * Date: 2022/9/4
 * Time: 14:22
 * File: ImageUploads.php
 */

namespace App\Services;


use Illuminate\Http\UploadedFile;

class ImageUploads
{
    /**
     * @var UploadedFile
     */
    protected UploadedFile $file;

    /**
     * @param $file
     * @return array
     * @Time 2022/9/4 14:26
     * @author qinghe
     */
    public function uploadAvatar($file): array
    {
        $this->file = $file;
        $allowedExtensions = ['png', 'jpg', 'jpeg', 'gif'];
        $check = $this->_check($allowedExtensions);
        if (!$check['status']) {
            return $check;
        }

        $destPath = public_path('uploads/avatar');

        $newFileName = md5(time() . rand(0, 10000)) . '.' . $this->file->getClientOriginalExtension();

        if (!$this->file->move($destPath, $newFileName)) {
            return ['status' => false, 'msg' => '系统异常，文件保存失败'];
        }

        return ['status' => true, 'fileName' => $newFileName];
    }

    /**
     * @param array $allowedExtensions
     * @return array|bool[]
     * @Time 2022/9/4 14:25
     * @author qinghe
     */
    private function _check(array $allowedExtensions): array
    {
        if (!$this->file->isValid()) {
            return ['status' => false, 'msg' => '文件上传失败'];
        }

        if (!$this->_checkAllowedExtensions($allowedExtensions)) {
            return ['status' => false, 'msg' => '非法的图片格式'];
        }

        if ($this->file->getSize() > 2 * 1024 * 1024) {
            return ['status' => false, 'msg' => '图片大小不能大于2M'];
        }

        return ['status' => true];
    }

    /**
     * @param array $allowedExtensions
     * @return bool
     * @Time 2022/9/4 14:25
     * @author qinghe
     */
    private function _checkAllowedExtensions(array $allowedExtensions): bool
    {
        //获取文件后缀名进行检查
        if (!in_array(strtolower($this->file->getClientOriginalExtension()), $allowedExtensions)) {
            return false;
        }

        return true;
    }
}
