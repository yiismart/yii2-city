<?php

use yii\helpers\Html;

// Title
$title = Yii::t('city', 'Add city');
$this->title = $title . ' | ' . Yii::$app->name;

// Breadcrumbs
$breadcrumbs = [
    ['label' => Yii::t('city', 'Cities'), 'url' => ['index']],
];
foreach ($parents as $item) {
    if (!$item->isRoot()) {
        $breadcrumbs[] = $item->name;
    }
}
$breadcrumbs[] = $title;
$this->params['breadcrumbs'] = $breadcrumbs;

?>
<h1><?= Html::encode($title) ?></h1>

<?= $this->render('form', [
    'model' => $model,
]) ?>
