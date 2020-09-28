<?php
/**
 * Created by PhpStorm.
 * User: lmnet
 * Date: 2020/9/27
 * Time: 3:37 PM
 */

namespace jason\dispatch\models;


use yii\redis\ActiveRecord;

class Agv extends ActiveRecord
{


    public function attributes()
    {
        return ['id', 'process_id', 'dis_id', 'map_name', 'src_id', 'box_rfid', 'state', 'task_id'];
    }

    public function load($data, $formName = null)
    {
        $this->state = 1;
        foreach ($data as $key => $val){
            $this->$key = $val;
        }
    }

}