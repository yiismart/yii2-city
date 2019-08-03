<?php

use yii\helpers\Html;
use yii\web\JsExpression;
use dkhlystov\widgets\NestedTreeGrid;
use smart\city\models\City;

// Title
$title = Yii::t('city', 'Cities');
$this->title = $title . ' | ' . Yii::$app->name;

// Breadcrumbs
$this->params['breadcrumbs'] = [
    $title,
];

?>
<h1><?= Html::encode($title) ?></h1>

<p class="form-buttons">
    <?= Html::a(Yii::t('cms', 'Add'), ['create'], ['class' => 'btn btn-primary']) ?>
</p>

<?= NestedTreeGrid::widget([
    'dataProvider' => $model->getDataProvider(),
    'initialNode' => $initial,
    'moveAction' => ['move'],
    'rowOptions' => function ($model, $key, $index, $grid) {
        $options = ['data-type' => $model->type];
        if (!$model->active) {
            Html::addCssClass($options, 'table-inactive');
        }
        return $options;
    },
    'pluginOptions' => [
        'onMoveOver' => new JsExpression('function (item, helper, target, position) {
            if (position == 1) return target.data("type") != ' . City::CITY . ';
            return true;
        }'),
    ],
    'columns' => [
        'name',
        [
            'class' => 'smart\grid\ActionColumn',
            'template' => '{update} {delete} {create}',
            'buttons' => [
                'create' => function ($url, $model, $key) {
                    $title = Yii::t('cms', 'Add');
                    return Html::a('<span class="fas fa-plus"></span>', $url, [
                        'title' => $title,
                        'aria-label' => $title,
                        'data-pjax' => 0,
                    ]);
                },
            ],
            'visibleButtons' => [
                'create' => function($model, $key, $index) {
                    return $model->type != City::CITY;
                },
            ],
        ],
    ],
]) ?>
