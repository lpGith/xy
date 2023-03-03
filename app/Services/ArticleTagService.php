<?php

declare(strict_types=1);

/**
 * Created by :phpstorm
 * User: qinghe
 * Date: 2022/9/3
 * Time: 18:01
 * File: ArticleTagService.php
 */

namespace App\Services;


use App\Repositories\ArticleTagRepositoryEloquent;
use App\Repositories\TagRepositoryEloquent;
use Prettus\Validator\Exceptions\ValidatorException;

class ArticleTagService
{
    /**
     * @var TagRepositoryEloquent
     */
    protected TagRepositoryEloquent $tags;

    /**
     * @var ArticleTagRepositoryEloquent
     */
    protected ArticleTagRepositoryEloquent $articleTags;

    /**
     * ArticleTagService constructor.
     * @param TagRepositoryEloquent $tags
     * @param ArticleTagRepositoryEloquent $articleTags
     */
    public function __construct(TagRepositoryEloquent $tags, ArticleTagRepositoryEloquent $articleTags)
    {
        $this->tags = $tags;
        $this->articleTags = $articleTags;
    }

    /**
     * @param int $articleId
     * @param string $tagNameString
     * Time 2022/9/3 18:14
     * @return bool
     * @throws ValidatorException
     * @author qinghe
     */
    public function store(int $articleId, string $tagNameString): bool
    {
        if ($tagNameString === '') {
            return false;
        }

        $tagNameList = array_unique(explode(';', trim($tagNameString, ';')));

        if (!$tagNameList) {
            return false;
        }

        foreach ($tagNameList as $tagName) {
            $tagData = $this->tags->findName($tagName);
            $data = [];
            $data['tag_id'] = count($tagData) > 0 ? $tagData['id'] : $this->tags->create(['name' => $tagName])->id;
            $data['article_id'] = $articleId;

            $this->articleTags->create($data);
        }

        return true;
    }

    /**
     * @param int $articleId
     * @param string $tagNameString
     * @return bool
     * @throws ValidatorException
     * @Time 2022/9/3 18:21
     * @author qinghe
     */
    public function updateArticleTags(int $articleId, string $tagNameString): bool
    {
        $this->articleTags->getModel()->where('article_id', $articleId)->delete();

        return $this->store($articleId, $tagNameString);
    }

    /**
     * @param $tags
     * @param bool $type
     * @return array|string
     * @Time 2022/9/3 18:24
     * @author qinghe
     */
    public function tagIdList($tags, bool $type = true)
    {
        $tagIdList = [];
        foreach ($tags as $tag) {
            $tagIdList[] = $tag->tag_id;
        }

        return $type ? $tagIdList : implode(',', $tagIdList);
    }
}
