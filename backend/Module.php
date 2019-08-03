<?php
namespace smart\city\backend;

use Yii;
use yii\helpers\Html;
use smart\base\BackendModule;
use smart\city\models\City;

class Module extends BackendModule
{
    /**
     * @inheritdoc
     */
    public static function database()
    {
        parent::database();

        // Cities root
        if (City::find()->roots()->count() == 0) {
            $root = new City(['name' => 'Root']);
            $root->makeRoot();
        }
    }

    /**
     * @inheritdoc
     */
    public static function security()
    {
        $auth = Yii::$app->getAuthManager();
        if ($auth->getRole('City') === null) {
            $role = $auth->createRole('City');
            $auth->add($role);
        }
    }

    /**
     * @inheritdoc
     */
    public function menu(&$items)
    {
        if (!Yii::$app->user->can('City')) {
            return;
        }

        $items['city'] = [
            'label' => '<i class="fas fa-city"></i> ' . Html::encode(Yii::t('city', 'Cities')),
            'encode' => false,
            'url' => ['/city/city/index'],
        ];
    }
}
