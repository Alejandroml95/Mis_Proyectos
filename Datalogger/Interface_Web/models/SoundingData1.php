<?php

namespace app\models;
use Yii;
use yii\db\ActiveRecord;
use app\models\FunctionSound;

class SoundingData1 extends FunctionSound {

    public static function getDb()
    {
        return Yii::$app->db; //Este archio php esta en config, db es el nombre
                              //del archivo que tiene los datos de la base de datos
    }

    public static function tableName()
    {
        return 'sounding1';
    }

}
