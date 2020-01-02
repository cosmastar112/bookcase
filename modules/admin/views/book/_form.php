<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Book */
/* @var $form yii\widgets\ActiveForm */

/* @var $error array */
?>

<div class="book-form">

    <!-- Если возникла ошибка, -->
    <?php if ( isset($error) ): ?>
        <!-- вывести ошибку -->
        <?= Html::tag('p', $error['descr'], [ 'class' => 'book-form__error' ]); ?>
        <!-- и найти значения полей формы, которые были введены ранее -->
        <?php 
            $title = $error['form']['title'];
            var_dump($error);
            $author = $error['form']['author'];
            var_dump($author);
        ?>
    <?php endif; ?>

    <?php $form = ActiveForm::begin(); ?>
    <!-- поле ввода имени автора -->
    <?= $form->field($model, 'title')->textInput(['maxlength' => true, 'value' => $title]) ?>
    <?= Html::label('Author', 'book-form__author-input', [ 'class' => "" ]) ?>

    <?= Html::textInput('author', $author, [ 
            'class' => "form-control", 
            'id' => "book-form__author-input",
    ]) ?>

    <?= Html::tag('p') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>
