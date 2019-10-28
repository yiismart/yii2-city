<?php
namespace smart\city\models;

use Yii;
use yii\db\ActiveQuery;
use smart\db\ActiveRecord;
use creocoder\nestedsets\NestedSetsBehavior;
use creocoder\nestedsets\NestedSetsQueryBehavior;
use dkhlystov\helpers\Translit;

class City extends ActiveRecord
{
    // Type
    const REGION = 0;
    const CITY = 1;

    /**
     * @var array type names
     */
    private static $typeNames = [
        self::REGION => 'Region',
        self::CITY => 'City',
    ];

    /**
     * @var array translated type names
     */
    private static $_typeNames;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'city';
    }

    /**
     * Types getter
     * @return array
     */
    public static function getTypes()
    {
        return array_keys(self::$typeNames);
    }

    /**
     * Type names getter
     * @return array
     */
    public static function getTypeNames()
    {
        if (self::$_typeNames !== null) {
            return self::$_typeNames;
        }

        return self::$_typeNames = array_map(function($v) {
            return Yii::t('city', $v);
        }, self::$typeNames);
    }

    /**
     * @inheritdoc
     * Default values
     */
    public function __construct($config = [])
    {
        parent::__construct(array_replace([
            'active' => true,
        ], $config));
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'tree' => [
                'class' => NestedSetsBehavior::className(),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function find()
    {
        return new CityQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        // Friendly Url
        if ($insert) {
            $this->makeAlias();
        } else {
            var_dump($insert); die();

        }

        return true;
    }

    /**
     * Make friendly url form name
     */
    public function makeAlias()
    {
        $this->alias = Translit::t($this->name);
    }
}

class CityQuery extends ActiveQuery
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            NestedSetsQueryBehavior::className(),
        ];
    }
}
