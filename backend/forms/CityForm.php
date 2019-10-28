<?php
namespace smart\city\backend\forms;

use Yii;
use smart\base\Form;
use smart\city\models\City;

class CityForm extends Form
{
    /**
     * @var boolean
     */
    public $active;

    /**
     * @var integer
     */
    public $type;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $alias;

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'active' => Yii::t('city', 'Active'),
            'type' => Yii::t('city', 'Type'),
            'name' => Yii::t('city', 'Name'),
            'alias' => Yii::t('city', 'Friendly URL'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            ['active', 'boolean'],
            ['type', 'in', 'range' => City::getTypes()],
            [['name', 'alias'], 'string', 'max' => 100],
            ['name', 'required'],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function map()
    {
        return [
            ['active', 'boolean'],
            ['type', 'integer'],
            [['name', 'alias'], 'string'],
        ];
    }
}
