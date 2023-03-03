<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Test;

/**
 * Class TestTransformer.
 *
 * @package namespace App\Transformers;
 */
class TestTransformer extends TransformerAbstract
{
    /**
     * Transform the Test entity.
     *
     * @param \App\Entities\Test $model
     *
     * @return array
     */
    public function transform(Test $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
