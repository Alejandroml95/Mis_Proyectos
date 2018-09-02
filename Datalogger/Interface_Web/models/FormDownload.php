<?php

namespace app\models;
use Yii;
use yii\base\model;

/**
 *
 */
class FormDownload extends model
{

  public $year;


  public function rules()
  {

    return [
      ["year", "match", "pattern" => "/^[0-9]/", "message" => "Sólo se aceptan letras y números"]
        ];

  }

  public function attributeLabels()
  {

    return [

      'year' => "Year"
    ];

  }

}
