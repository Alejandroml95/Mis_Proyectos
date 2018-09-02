<?php

namespace app\models;
use Yii;
use yii\db\ActiveRecord;

class dbUser extends ActiveRecord{

    public static function getDb()
    {
        return Yii::$app->db; //Este archio php esta en config, db es el nombre
                              //del archivo que tiene los datos de la base de datos
    }

    public static function tableName()
    {
        return 'backend_user';
    }

}
