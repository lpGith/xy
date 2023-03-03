<?php

namespace App\Presenters;

use App\Transformers\TestTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class TestPresenter.
 *
 * @package namespace App\Presenters;
 */
class TestPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new TestTransformer();
    }
}
