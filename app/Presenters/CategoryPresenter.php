<?php


namespace App\Presenters;


use App\Repositories\CategoryRepositoryEloquent;
use App\Transformers\CategoryTransformer;
use Prettus\Repository\Presenter\FractalPresenter;
use BmobObject;

class CategoryPresenter extends FractalPresenter
{

    /**
     * @var CategoryRepositoryEloquent
     */
    protected CategoryRepositoryEloquent $category;

    public function __construct(CategoryRepositoryEloquent $category)
    {
        $this->category = $category;
        parent::__construct();
    }

    /**
     * @return CategoryTransformer
     */
    public function getTransformer(): CategoryTransformer
    {
        return new CategoryTransformer();
    }

    /**
     * @param int $defaultCategoryId
     * @param string $nullText
     * @param  $nullValue
     * @return string
     * @Time 2022/9/4 19:37
     * @author qinghe
     */
    public function getSelect(int $defaultCategoryId = 0, string $nullText = '请选择', $nullValue = 0): string
    {
        $category = $this->category->getNestedList();

        return $this->getString($defaultCategoryId, $nullText, $nullValue, $category);
    }

    /**
     * @param int $defaultCategoryId
     * @param string $nullText
     * @param  $nullValue
     * @param $category
     * @return string
     * @Time 2022/9/4 19:38
     * @author qinghe
     */
    public function getString(int $defaultCategoryId = 0, string $nullText = '请选择',  $nullValue = 0, $category): string
    {
        $select = "<select id='cate_id' name='cate_id' class='form-control'>";
        $select .= "<option value='" . $nullValue . "'>--" . $nullText . "--</option>";
        if ($category) {
            foreach ($category as $key => $value) {
                $selected = $key == $defaultCategoryId ? "selected" : "";
                $select .= "<option value='" . $key . "' " . $selected . ">" . $value . "</option>";
            }
        }
        $select .= "</select>";

        return $select;
    }
}
