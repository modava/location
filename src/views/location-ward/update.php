<?php

use modava\location\widgets\NavbarWidgets;
use yii\helpers\Html;
use yii\helpers\Url;
use modava\location\LocationModule;

/* @var $this yii\web\View */
/* @var $model modava\location\models\LocationWard */

$this->title = LocationModule::t('location', 'Update : {name}', [
    'name' => $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => LocationModule::t('location', 'Country'), 'url' => ['/location']];
$this->params['breadcrumbs'][] = ['label' => LocationModule::t('location', 'Ward'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = LocationModule::t('location', 'Update');
?>
<div class="container-fluid px-xxl-25 px-xl-10">
    <?= NavbarWidgets::widget(); ?>

    <!-- Title -->
    <div class="hk-pg-header">
        <h4 class="hk-pg-title"><span class="pg-title-icon"><span
                        class="ion ion-md-apps"></span></span><?= Html::encode($this->title) ?>
        </h4>
        <a class="btn btn-outline-light" href="<?= Url::to(['create']); ?>"
           title="<?= LocationModule::t('location', 'Create'); ?>">
            <i class="fa fa-plus"></i> <?= LocationModule::t('location', 'Create'); ?></a>
    </div>
    <!-- /Title -->

    <!-- Row -->
    <div class="row">
        <div class="col-xl-12">
            <section class="hk-sec-wrapper">
                <?= $this->render('_form', [
                    'model' => $model,
                ]) ?>

            </section>
        </div>
    </div>
</div>
