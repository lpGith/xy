<?php

namespace App\Transformers;


use App\Models\User;
use League\Fractal\TransformerAbstract;


class UserTransformer extends TransformerAbstract
{

    /**
     * @param User $model
     * @return array
     */
    public function getTransformer(User $model): array
    {
        return [
            'id' => (int)$model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }

}
