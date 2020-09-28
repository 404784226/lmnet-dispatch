<?php
/**
 * Created by PhpStorm.
 * User: lmnet
 * Date: 2020/9/27
 * Time: 3:24 PM
 */

namespace jason\dispatch\models;


use yii\redis\ActiveRecord;

class Request extends ActiveRecord
{
    public function attributes()
    {
        return ['id', 'process_id', 'dis_id', 'dis_pos_num', 'map_name'];
    }

    public function load($data, $formName = null)
    {
        foreach ($data as $key => $val){
            $this->$key = $val;
        }
    }



}