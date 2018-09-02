<?php

namespace app\models;
use Yii;
use yii\base\model;

/**
 *
 */
class FormSearch extends model
{

  public $FirstDate;
  public $EndDate;

  public function rules()
  {

    return [
      ["FirstDate", "match", "pattern" => "/([12]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01]))/", "message" => "Sólo se aceptan letras y números"] ,
      ["EndDate", "match", "pattern" => "/([12]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01]))/", "message" => "Sólo se aceptan letras y números"]
        ];
  }

  public function attributeLabels()
  {

    return [

      'FirstDate' => "First Date",
      'EndDate' => "Last Date"

    ];

  }

}
