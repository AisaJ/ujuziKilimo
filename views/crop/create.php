<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Crop */

$this->title = 'Create Crop';
$this->params['breadcrumbs'][] = ['label' => 'Crops', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="crop-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
