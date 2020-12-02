<?php

namespace ereminmdev\yii2\sortablejs;

use Yii;
use yii\base\Action;
use yii\base\InvalidConfigException;
use yii\db\ActiveRecord;
use yii\db\ActiveRecordInterface;

/**
 * Class SortableJsAction
 * @package ereminmdev\yii2\sortablejs
 */
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
    /**
     * @var string post parameter with sortable ids
     */
    public $postOldParam = 'oldOrder';

    /**
     * @throws InvalidConfigException
     */
    public function run()
    {
        /** @var ActiveRecord $class */
        $class = Yii::$app->request->get('model', $this->modelClass);

        $ids = Yii::$app->request->post($this->postParam, []);
        if (count($ids) < 2) {
            throw new InvalidConfigException("Count of items of parameter `$this->postParam` is less than 2.");
        }

        $oldIds = Yii::$app->request->post($this->postOldParam, []);
        if (count($oldIds) != count($ids)) {
            throw new InvalidConfigException("Count of items of parameters `$this->postParam` and `$this->postOldParam` is not equal.");
        }

        $models = $class::find()
            ->andWhere([$this->idAttribute => $ids])
            ->indexBy($this->idAttribute)
            ->all();

        if (count($models) != count($ids)) {
            throw new InvalidConfigException("Count of items of parameter `$this->postParam` and found models `$this->postOldParam` is not equal.");
        }

        $positions = [];
        foreach ($oldIds as $id) {
            $positions[] = $models[$id]->getAttribute($this->sortAttribute);
        }

        foreach ($ids as $idx => $id) {
            $model = $models[$id];
            $model->setAttribute($this->sortAttribute, $positions[$idx]);
            $model->save();
        }
    }
}
