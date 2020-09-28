<?php
/**
 * Created by PhpStorm.
 * User: lmnet
 * Date: 2020/9/27
 * Time: 3:24 PM
 */

namespace jason\dispatch\models;


use yii\redis\ActiveRecord;

class Supply extends ActiveRecord
{
    public function attributes()
    {
        return ['id', 'process_id', 'src_id', 'src_pos_num', 'map_name', 'box_id', 'box_rfid', 'order_step_id'];
    }

    public function load($data, $formName = null)
    {
        foreach ($data as $key => $val){
            $this->$key = $val;
        }
    }

}