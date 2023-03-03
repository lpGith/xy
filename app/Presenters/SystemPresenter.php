<?php

namespace App\Presenters;


use App\Repositories\SystemRepositoryEloquent;
use App\Transformers\SystemTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class SystemPresenter
 * @package App\Presenters
 */
class SystemPresenter extends FractalPresenter
{
    /**
     * @var SystemRepositoryEloquent
     */
    protected SystemRepositoryEloquent $system;

    /**
     * @var array
     */
    protected array $list;

    /**
     * SystemPresenter constructor.
     * @param SystemRepositoryEloquent $system
     * @throws \Exception
     */
    public function __construct(SystemRepositoryEloquent $system)
    {
        $this->system = $system;
        $this->list = $this->system->optionList();
        parent::__construct();
    }

    /**
     * Get Transformer
     * @return SystemTransformer
     */
    public function getTransformer(): SystemTransformer
    {
        // TODO: Implement getTransformer() method.
        return new SystemTransformer();
    }

    /**
     * 根据key获取value
     * Get the specified value.
     * @param $key
     * @return bool
     */
    public function getKeyValue($key)
    {
        return $this->list[$key] ?? "";
    }

    /**
     * 检查是否有值
     * @param $key
     * @param $defaultValue
     * @return bool
     */
    public function checkReturnValue($key,$defaultValue)
    {
        if($defaultValue !=""){
            return $defaultValue;
        }
        return $this->getKeyValue($key);
    }

}
