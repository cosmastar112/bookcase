<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "register".
 *
 * @property int $id
 * @property int $book_id
 * @property string $date_start
 * @property string $date_end
 *
 * @property Book $book
 */
class Register extends \yii\db\ActiveRecord
{
    // поле формы для ввода названия книги; не будет сохранено в БД
    public $book_title;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'register';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['book_id', 'book_title', 'date_start', 'date_end'], 'required'],
            [['book_id'], 'integer'],
            [['date_start', 'date_end'], 'date', 'format' => 'php:Y-m-d'],
            [['date_start', 'date_end'], 'safe'],
            [['book_id'], 'exist', 'skipOnError' => true, 'targetClass' => Book::className(), 'targetAttribute' => ['book_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'book_id' => 'Book ID',
            'date_start' => 'Date Start',
            'date_end' => 'Date End',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBook()
    {
        return $this->hasOne(Book::className(), ['id' => 'book_id']);
    }
}
