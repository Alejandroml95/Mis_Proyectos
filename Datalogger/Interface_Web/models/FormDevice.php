<?php

namespace app\models;
use Yii;
use yii\base\model;

/**
 *
 */
class FormDevice extends model
{

  public $tipo;
  public $tipo_nom;
  public $nom;

  public function rules()
  {

    return [
          ['tipo', 'required', 'message' => 'Campo requerido'],
          ['tipo_nom', 'required', 'message' => 'Campo requerido'],
          ['nom', 'required', 'message' => 'Campo requerido']
        ];
  }

  public function attributeLabels()
  {

    return [

      'tipo' => "Type",
      'tipo_nom' => "Nº Device",
      'nom' => "Name"

    ];

  }

}
