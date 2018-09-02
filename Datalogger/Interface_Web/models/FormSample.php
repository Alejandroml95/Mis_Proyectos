<?php

namespace app\models;
use Yii;
use yii\base\model;

/**
 *
 */
class FormSample extends model
{

  public $id;
  public $sampletime;

  public function rules()
  {

    return [
          ['id', 'required', 'message' => 'Campo requerido'],
          ['sampletime', "match", "pattern" => "/^\d+$/", "message" => "Sólo se aceptan números enteros"]
        ];
  }

  public function attributeLabels()
  {

    return [

      'id' => "Id",
      'sampletime' => "SampleTime"
    ];

  }

}
