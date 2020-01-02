<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Book */
/* @var $form yii\widgets\ActiveForm */

/* @var $error array */
?>

<div class="book-form">

    <!-- Если возникла ошибка ввода имени автора -->
    <?php if ( isset($error) ): ?>
        <!-- вывести ошибку -->
        <?php $err = $error['descr'] . " '{$error['author']}'"; ?>
        <?= Html::tag('p', $err, [ 'class' => 'book-form__error' ]); ?>
        <!-- и найти значения ранее введенные в поля формы -->
        <?php $title = $error['form']['title']; var_dump($error); ?>
    <?php endif; ?>

    <?php $form = ActiveForm::begin(); ?>
    <!-- поле ввода имени автора -->
    <?= $form->field($model, 'title')->textInput(['maxlength' => true, 'value' => $title]) ?>
    <?= Html::label('Author', 'book-form__author-input', [ 'class' => "" ]) ?>
    <?= Html::textInput('author', null, [ 'class' => "form-control", 'id' => "book-form__author-input" ]) ?>
    <?= Html::tag('p') ?>
    
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>
