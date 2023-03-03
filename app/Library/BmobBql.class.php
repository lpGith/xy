<?php

include_once 'BmobRestClient.class.php';

/**
 * BmobUser batch对象类
 * @author karvinchen
 * @license http://www.gnu.org/copyleft/lesser.html Distributed under the Lesser General Public License (LGPL)
 */
class BmobBql extends BmobRestClient
{

    public function __construct($class = '')
    {
        parent::__construct();
    }


    /**
     * 批量操作
     * @param array $data 查询条件
     * @throws BmobException
     */
    public function query(array $data)
    {
        if (!empty($data)) {

            $this->data["requests"] = $data;
            return $this->sendRequest(array(
                'method' => 'GET',
                'sendRequestUrl' => 'cloudQuery',
                'urlParams' => $data,
            ));
        } else {
            $this->throwError('查询条件不能为空');
        }
    }


}

