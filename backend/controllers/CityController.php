<?php
namespace smart\city\backend\controllers;

use Yii;
use yii\web\BadRequestHttpException;
use smart\base\BackendController;
use smart\city\backend\filters\CityFilter;
use smart\city\backend\forms\CityForm;
use smart\city\models\City;

class CityController extends BackendController
{
    /**
     * Tree
     * @param integer|null $id Initial item id
     * @return string
     */
    public function actionIndex($id = null)
    {
        $model = new CityFilter;
        $model->load(Yii::$app->getRequest()->get());

        return $this->render('index', [
            'model' => $model, 
            'initial' => City::findOne($id),
        ]);
    }

    /**
     * Create
     * @param integer|null $id Parent id
     * @return string
     */
    public function actionCreate($id = null)
    {
        $parent = City::findOne($id);
        if ($parent === null) {
            $parent = City::find()->roots()->one();
        }

        $object = new City;
        $model = new CityForm;
        $model->assignFrom($object);

        if ($model->load(Yii::$app->getRequest()->post()) && $model->validate()) {
            $model->assignTo($object);
            $object->appendTo($parent, false);

            Yii::$app->getSession()->setFlash('success', Yii::t('cms', 'Changes saved successfully.'));
            return $this->redirect(['index', 'id' => $object->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'id' => $id,
            'parents' => array_merge($parent->parents()->all(), [$parent]),
        ]);
    }

    /**
     * Update
     * @param integer $id
     * @return string
     */
    public function actionUpdate($id)
    {
        $object = City::findOne($id);
        if ($object === null || $object->isRoot()) {
            throw new BadRequestHttpException(Yii::t('cms', 'Item not found.'));
        }

        $model = new CityForm;
        $model->assignFrom($object);

        if ($model->load(Yii::$app->getRequest()->post()) && $model->validate()) {
            $model->assignTo($object);
            $object->save(false);

            Yii::$app->getSession()->setFlash('success', Yii::t('cms', 'Changes saved successfully.'));
            return $this->redirect(['index', 'id' => $object->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'object' => $object,
            'id' => $object->id,
            'parents' => $object->parents()->all(),
        ]);
    }

    /**
     * Delete
     * @param integer $id
     * @return string
     */
    public function actionDelete($id)
    {
        $object = City::findOne($id);
        if ($object === null || $object->isRoot()) {
            throw new BadRequestHttpException(Yii::t('cms', 'Item not found.'));
        }

        $initial = $object->prev()->one();
        if ($initial === null) {
            $initial = $object->next()->one();
        }
        if ($initial === null) {
            $initial = $object->parents(1)->one();
        }

        if ($object->deleteWithChildren()) {
            Yii::$app->getSession()->setFlash('success', Yii::t('cms', 'Item deleted successfully.'));
        }

        return $this->redirect(['index', 'id' => $initial ? $initial->id : null]);
    }

    /**
     * Move
     * @param integer $id 
     * @param integer $target 
     * @param integer $position 
     * @return void
     */
    public function actionMove($id, $target, $position)
    {
        $object = City::findOne($id);
        if ($object === null || $object->isRoot()) {
            throw new BadRequestHttpException(Yii::t('cms', 'Item not found.'));
        }

        $t = City::findOne($target);
        if ($t === null || $t->isRoot()) {
            throw new BadRequestHttpException(Yii::t('cms', 'Item not found.'));
        }

        if ($position == 1 && $t->type == City::CITY) {
            throw new BadRequestHttpException(Yii::t('cms', 'Operation not permitted.'));
        }

        switch ($position) {
            case 0:
                $object->insertBefore($t);
                break;

            case 1:
                $object->appendTo($t);
                break;
            
            case 2:
                $object->insertAfter($t);
                break;
        }
    }
}
