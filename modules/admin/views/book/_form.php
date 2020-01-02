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
            $author_name = $error['form']['author_name'];
            var_dump($author_name);
        ?>
    <?php else: ?>
        <!-- На случай если переход произошел из представления update -->
        <?php
            if ( isset($update) ) {
                $author_name = $update['author_name'];
            }
        ?>
    <?php endif; ?>

    <?php $form = ActiveForm::begin([ 'id' => 'book-form__afw']); ?>
    <!-- Поле ввода названия книги -->
    <?= $form->field($model, 'title')->textInput(['maxlength' => true, 'value' => $title]) ?>

    <!-- Поле ввода имени автора -->
    <?= $form->field($model, 'author_name')->textInput(['maxlength' => true, 'value' => $author_name]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>
