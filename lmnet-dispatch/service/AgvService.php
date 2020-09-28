<?php
/**
 * Created by PhpStorm.
 * User: lmnet
 * Date: 2020/9/25
 * Time: 5:34 PM
 */
namespace jason\dispatch\service;

use components\DispatchJob;
use oueng\dispatch\models\Agv;
use oueng\dispatch\models\Request;
use oueng\dispatch\models\Supply;
use Yii;
use yii\helpers\ArrayHelper;

class AgvService
{

    /**
     * 产线调用 下道工序拉取工作任务
     * @param $param
     *  process_id 当前工序ID
     *  dis_id B点点位ID
     *  dis_pos_num 工位编号
     *  map_name 地图名称
     * @return bool
     */
    public static function addRequest($param)
    {

        $supply = Supply::find()->where(['process_id' => $param['process_id']])->asArray()->one();
        if(!empty($supply)){
            static::sendTask([array_merge(ArrayHelper::toArray($supply), $param)]);
            Supply::deleteAll(['id' => $supply['id']]);
            return true;
        }
        $request = new Request();
        $request->load($param);
        $request->save();
        return true;


    }


    /**
     * 产线调用，工序完成，请求机器人搬走料箱
     * @param $param
     * process_id 当前工序ID
     * src_id A点点位ID
     * src_pos_num A点工位编号
     * map_name 地图名称
     * box_id 料箱ID
     * box_rfid 料箱RFID编号
     * order_step_id 工单步骤ID
     *
     * @return bool
     */
    public static function addSupply($param)
    {
        $request = Request::find()->where(['process_id' => $param['process_id']])->one();
        if(!empty($request)){
            static::sendTask([array_merge(ArrayHelper::toArray($request), $param)]);
            Request::deleteAll(['id' => $request->id]);
            return true;
        }

        $supply = new Supply();
        $supply->load($param);
        $supply->save();
        return true;
    }


    /**
     *
     * @param $request
     * @param $supply
     * @return bool
     */
    public static function sendTask($data)
    {
        foreach ($data as $item){
            $agv = new Agv();
            $param = [
                'process_id' => $item['process_id'],
                'dis_id' => $item['dis_id'],
                'map_name' => $item['map_name'],
                'src_id' => $item['src_id'],
                'box_rfid' => $item['box_rfid'],
                'state' => 1,
            ];
            $agv->load($param);
            $agv->save();
            Yii::$app->queue->push(new DispatchJob([
                'url' => 'http://example.com/image.jpg',
                'file' => '/tmp/image.jpg',
            ]));
        }
        return true;
    }


}