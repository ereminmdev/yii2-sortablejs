<?php

namespace ereminmdev\yii2\sortablejs;

use Yii;
use yii\base\Action;
use yii\db\ActiveRecordInterface;


class SortableJsAction extends Action
{
    /**
     * @var string|ActiveRecordInterface model class name
     */
    public $modelClass;
    /**
     * @var string sortable model attribute
     */
    public $sortAttribute = 'position';
    /**
     * @var string id model attribute
     */
    public $idAttribute = 'id';
    /**
     * @var string post parameter with sortable ids
     */
    public $postParam = 'order';


    public function run()
    {
        $class = Yii::$app->request->get('model', $this->modelClass);

        $order = Yii::$app->request->post($this->postParam, []);
        if (count($order) < 2) return;

        $positions = $class::find()
            ->select($this->sortAttribute)
            ->andWhere([$this->idAttribute => $order])
            ->column();

        foreach ($order as $id) {
            $position = array_shift($positions);
            if ($position !== null) {
                $model = $class::findOne([$this->idAttribute => $id]);
                if ($model !== null) {
                    $model->setAttribute($this->sortAttribute, $position);
                    $model->save();
                }
            } else {
                break;
            }
        }
    }
}
