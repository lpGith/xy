<?php

declare(strict_types=1);

/**
 * Created by :phpstorm
 * User: qinghe
 * Date: 2022/9/4
 * Time: 19:22
 * File: BackendPresenter.php
 */

namespace App\Presenters;

use Illuminate\Support\Facades\Route;

class BackendPresenter
{
    /**
     * @var
     */
    private $route;

    /**
     * @author qinghe
     * @Time 2022/9/4 19:27
     */
    public function menu(): string
    {
        $this->route = Route::currentRouteName();
        $menu = config('blog.menu');

        $menuString = '';
        foreach ($menu as $mList) {
            $count = count($mList);
            if ($count > 1) {
                $menuString .= $this->_childrenShow($mList);
            } else {
                $menuString .= $this->_parentShow($mList);
            }
        }

        return $menuString;
    }

    /**
     * @param $menu
     * @return string
     * @Time 2022/9/4 19:27
     * @author qinghe
     */
    private function _childrenShow($menu): string
    {
        $string = '<li class="treeview %s">';
        $string .= '<a href="#">
                    <i class="' . $menu['tree_title']['icon'] . '"></i>
                    <span>' . $menu['tree_title']['name'] . '</span>
                    <i class="fa fa-angle-left pull-right"></i>
                    </a> ';
        unset($menu['tree_title']);
        $string .= '<ul class="treeview-menu"> %s </ul>';
        $liString = '';
        $active = '';

        foreach ($menu as $route => $m) {
            $activeString = $this->_active($route);
            if ($activeString != '') {
                $active = $activeString;
            }
            $liString .= "<li class='" . $activeString . "'><a href='" . route($route) . "'>" . $m['name'] . '</a></li>';
        }
        $string .= '</li>';

        return sprintf($string, $active, $liString);
    }

    /**
     * @param $menu
     * @return string
     * @Time 2022/9/4 19:27
     * @author qinghe
     */
    private function _parentShow($menu): string
    {
        $string = '';
        foreach ($menu as $route => $m) {
            $string .= "<li class='treeview " . $this->_active($route) . "'>
                <a href='" . route($route) . "'>
                    <i class='" . $m['icon'] . "'></i>
                    <span>" . $m['name'] . '</span>
                </a>
            </li>';
        }

        return $string;
    }

    /**
     * @param $route
     * @return string
     * @Time 2022/9/4 19:26
     * @author qinghe
     */
    private function _active($route): string
    {
        return $this->route == $route ? 'active' : '';
    }
}
