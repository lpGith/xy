<?php

namespace App\Presenters;


use App\Repositories\NavigationRepositoryEloquent;
use App\Transformers\NavigationTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

class NavigationPresenter extends FractalPresenter
{
    /**
     * @var NavigationRepositoryEloquent
     */
    protected NavigationRepositoryEloquent $navigation;

    /**
     * NavigationPresenter constructor.
     * @param NavigationRepositoryEloquent $navigation
     * @throws \Exception
     */
    public function __construct(NavigationRepositoryEloquent $navigation)
    {
        $this->navigation = $navigation;
        parent::__construct();
    }

    /**
     * Get Transformer
     * @return NavigationTransformer
     */
    public function getTransformer(): NavigationTransformer
    {
        return new NavigationTransformer();
    }

    /**
     * 获取导航列表
     * Get the list of the navigation
     * @return mixed
     */
    public function getNavList()
    {
        return $this->navigation->orderBy('sequence', 'desc')->findWhere(['state' => 0], ['name', 'url']);
    }

}
