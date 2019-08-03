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
    public $url;

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'active' => Yii::t('city', 'Active'),
            'type' => Yii::t('city', 'Type'),
            'name' => Yii::t('city', 'Name'),
            'url' => Yii::t('city', 'Url'),
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
            [['name', 'url'], 'string', 'max' => 100],
            ['name', 'required'],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function assignFrom($object)
    {
        $this->active = self::fromBoolean($object->active);
        $this->type = self::fromInteger($object->type);
        $this->name = self::fromString($object->name);
        $this->url = self::fromString($object->url);
    }

    /**
     * @inheritdoc
     */
    public function assignTo($object)
    {
        $object->active = self::toBoolean($this->active);
        $object->type = self::toInteger($this->type);
        $object->name = self::toString($this->name);
        $object->url = self::toString($this->url, true);
    }
}
