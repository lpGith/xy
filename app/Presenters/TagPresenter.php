<?php

namespace App\Presenters;

use App\Repositories\TagRepositoryEloquent;
use App\Transformers\TagTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

class TagPresenter extends FractalPresenter
{
    /**
     * @var TagRepositoryEloquent
     */
    protected TagRepositoryEloquent $tag;

    public function __construct(TagRepositoryEloquent $tag)
    {
        $this->tag = $tag;
        parent::__construct();
    }

    /**
     * @return TagTransformer
     */
    public function getTransformer(): TagTransformer
    {
        return new TagTransformer();
    }

    /**
     * @param $idList
     * @return string
     */
    public function tagNameList($idList): string
    {
        $tagName = "";
        if ($idList != "") {
            $tags = $this->tag->findWhereIn('id',explode(',',$idList),['name']);
            if($tags){
                foreach ($tags as $tag){
                    $tagName .= $tag->name . ";";
                }
            }
        }
        return $tagName;
    }

    /**
     * @return mixed
     */
    public function tagList()
    {
        return $this->tag->all(['id', 'name']);
    }


}
