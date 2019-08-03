<?php
namespace smart\city\models;

use smart\db\ActiveRecord;
use creocoder\nestedsets\NestedSetsBehavior;
use creocoder\nestedsets\NestedSetsQueryBehavior;

class City extends ActiveRecord
{
    // Type
    const REGION = 0;
    const CITY = 1;

    /**
     * @var array taye names
     */
    private static $typeNames = [
        self::REGION => 'Region',
        self::CITY => 'City',
    ];

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
