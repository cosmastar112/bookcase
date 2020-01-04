<?php

/* @var $this yii\web\View */

use yii\helpers\Url;

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Прочитал новую книгу?</h1>

        <p class="lead">Добавь информацию для отслеживания своей читательской статистики.</p>

        <p><a class="btn btn-lg btn-success" href= <?= Url::to(['/admin/register/create']) ?>>Добавить запись в регистр</a></p>

    </div>

    <h3>Также ты можешь посмотреть...</h2>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>Таблицы</h2>
                <ul>
                    <li>
                        <a class="" href= <?= Url::to(['/authors/index']) ?> >Авторы</a>
                    </li>
                    <li>
                        <a class="" href= <?= Url::to(['/books/index']) ?> >Книги</a>
                    </li>
                    <li>
                        <a class="" href= <?= Url::to(['/register/index']) ?> >Регистр</a>
                    </li>
                </ul>

            </div>
            <div class="col-lg-4">
                <h2>Статистику</h2>


            </div>
            <div class="col-lg-4">
                <h2>Что-то ещё</h2>
            </div>
        </div>

    </div>
</div>
