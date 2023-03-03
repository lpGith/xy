<?php

namespace App\Presenters;


use App\Repositories\LinkRepositoryEloquent;
use App\Transformers\LinkTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

class LinkPresenter extends FractalPresenter
{
    /**
     * @var LinkRepositoryEloquent
     */
    protected LinkRepositoryEloquent $link;

    /**
     * LinkPresenter constructor.
     * @param LinkRepositoryEloquent $link
     * @throws \Exception
     */
    public function __construct(LinkRepositoryEloquent $link)
    {
        $this->link = $link;
        parent::__construct();
    }

    /**
     * @return LinkTransformer
     */
    public function getTransformer(): LinkTransformer
    {
        // TODO: Implement getTransformer() method.
        return new LinkTransformer();
    }

    /**
     * 获取友情链接
     * Get the listing of the link.
     * @return mixed
     */
    public function linkList()
    {
        return $this->link->orderBy('sequence', 'desc')->all(['name', 'url']);
    }

}
