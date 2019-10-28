<?php

use smart\city\models\City;
use smart\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use smart\city\backend\assets\CityAsset;

CityAsset::register($this);

?>
<?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'active')->checkbox(); ?>

    <?= $form->field($model, 'type')->dropDownList(City::getTypeNames()); ?>

    <?= $form->field($model, 'name'); ?>

    <?= $form->field($model, 'alias', ['append' => [
        ['button' => '<i class="fas fa-sync"></i>', 'options' => ['id' => 'make-alias', 'data-url' => Url::toRoute(['make-alias'])]],
    ]]); ?>

    <div class="form-group form-buttons row">
        <div class="col-sm-10 offset-sm-2">
            <?= Html::submitButton(Yii::t('cms', 'Save'), ['class' => 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('cms', 'Cancel'), ['index'], ['class' => 'btn btn-secondary']) ?>
        </div>
    </div>

<?php ActiveForm::end(); ?>
