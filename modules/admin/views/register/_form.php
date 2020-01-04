<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Register */
/* @var $form yii\widgets\ActiveForm */
?>

<p> Укажите название книги, дату начала и окончания прочтения.</p>

<div class="register-form">

    <!-- Если возникла ошибка, -->
    <?php if ( isset($error) ): ?>
        <!-- вывести ошибку -->
        <?= Html::tag('p', $error['descr'], [ 'class' => 'register-form__error' ]); ?>
        <!-- и найти значения полей формы, которые были введены ранее -->
        <?php 
            $book_title = $error['form']['book_title'];
            var_dump($error);
            $date_start = $error['form']['date_start'];
            var_dump($date_start);
            $date_end = $error['form']['date_end'];
            var_dump($date_end);
        ?>
    <?php else: ?>
        <!-- На случай если переход произошел из представления update -->
        <?php
            // if ( isset($update) ) {
            //     $author_name = $update['author_name'];
            // }
        ?>
    <?php endif; ?>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'book_title')->textInput(['value' => $book_title]) ?>

    <?= $form->field($model, 'date_start')->widget(DatePicker::className(), [
        'options' => [ 'placeholder' => 'Дата начала чтения ...', 'value' => $date_start ],
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'dd.mm.yyyy'
        ]
    ]) ?>

    <?= $form->field($model, 'date_end')->widget(DatePicker::className(), [
        'options' => [ 'placeholder' => 'Дата прочтения ...', 'value' => $date_end ],
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'dd.mm.yyyy'
        ]
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
