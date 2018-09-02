<?php

namespace app\models;
use Yii;
use yii\db\ActiveRecord;
use app\models\FunctionSound;

class FunctionSound extends ActiveRecord{

  public function FilterDay($search)
  {

    $Months =  ["January", "Febrary","March","April","May","June","July",
                "August", "September", "October", "November", "Dicember"];

    $d = "$search[8]"."$search[9]";
    $m = "$search[5]"."$search[6]";
    $intm = intval($m);

    if ( $intm > 9) {
      $m = "$search[5]"."$search[6]";
      $m = intval($m);
    } else {
      $m = "$search[6]";
      $m = intval($m);
    }

    $y = "$search[0]"."$search[1]"."$search[2]"."$search[3]";

    $FilterDay = $d. " of ".$Months[$m - 1].", ".$y;

    return $FilterDay;

  }

  public function XasisTime($model, $Search)
  {

    $XasisTime = $model::find()

            -> where(["LIKE", "Fecha", $Search ])
            -> select('Horario') -> asArray() -> all();

    $XasisTime = array_map('end', $XasisTime); //Eliminamos los array dentrto del array
    $XasisTime = array_values($XasisTime);

    return $XasisTime;

  }

  public function DataDay($model, $Search, $NameRow)
  {

    //Filtramos los datos pasados por el usuarios
    $Data = $model::find()

              -> where(["LIKE", "Fecha", $Search ])
              -> select( $NameRow ) -> asArray() -> all();

    $Data = array_map('end', $Data);
    $Data = array_values($Data);
    $Data = array_map('floatval', $Data);

    return $Data;

  }


  public function AverageDay($model, $Search, $NameRow)
  {

    $AverageDay = $model::find()

              -> where(["LIKE", "Fecha", $Search ])
              -> select('Temperatura') -> asArray() -> average( $NameRow );

    $AverageDay = round($AverageDay, 2);

    return $AverageDay;

  }

  public function MaxDay($model, $Search, $NameRow)
  {

    $MaxDay = $model::find()

              -> where(["LIKE", "Fecha", $Search ])
              -> select('Temperature') -> asArray() -> max( $NameRow );

    $MaxDay = round($MaxDay, 2);

    return $MaxDay;

  }

  public function MinDay($model, $Search, $NameRow)
  {

    $MinDay = $model::find()

              -> where(["LIKE", "Fecha", $Search ])
              -> select('Temperatura') -> asArray() -> min( $NameRow );

    $MinDay = round($MinDay, 2);

    return $MinDay;

  }

  public function arrayDay($model, $Search)
  {

    for ($i = 7; $i >= 0 ; $i--) {

      $strnumber = (string)$i;
      $str = '-'.$strnumber.' day';

      $LastDay = strtotime ( $str , strtotime ( $Search ) ) ;
      $LastDay = date ( 'Y-m-d' , $LastDay );

      $Day[7 - $i] = $LastDay;
    }

    return $Day;

  }

  public function AverageWeek($model, $Search, $NameRow)
  {

    for ($i = 7; $i >= 0 ; $i--) {

      $strnumber = (string)$i;
      $str = '-'.$strnumber.' day';

      $LastDay = strtotime ( $str , strtotime ( $Search ) ) ;
      $LastDay = date ( 'Y-m-d' , $LastDay );

      $AverageWeek[7 - $i] = $model::find()

              -> where(["LIKE", "Fecha", $LastDay ])
              -> select( $NameRow ) -> asArray() -> average( $NameRow );

      $AverageWeek[7 - $i] = round($AverageWeek[7 - $i], 2);
      //$AverageTempWeek[7 - $i] = (int)$AverageTempWeek[7 - $i];

    }

    return $AverageWeek;

  }

  public function AverageMonth($model, $NameRow)
    {

      for ($i = 0 ; $i < 12 ; $i++) {

        $strnumber = (string)$i;
        $str = '+'.$strnumber.' month';
        $date = strftime( "%Y", time() );
        $date = $date."-1";

        $LastMonth = strtotime ( $str , strtotime ( $date ) ) ;
        $LastMonth = date ( 'Y-m' , $LastMonth );

        $AverageMonth[$i] = $model::find()

              -> where(["LIKE", "Fecha", $LastMonth ])
              -> select( $NameRow ) -> asArray() -> average( $NameRow );

        $AverageMonth[$i] = (int)$AverageMonth[$i];

      }

      return $AverageMonth;

    }

  public function SampleTime($model, $id)
  {

    $sampleTime = $model::find() -> where(["LIKE", "id", $id ])
    -> select('sampleTime') -> asArray() -> min( "sampleTime" );
                                  
    
    //$sampleTime[0] = (string) $sampleTime[0];

    return $sampleTime;

  }

  public function Percentage($value, $max, $min)
  {

    $result = ($value - $min)/($max - $min);
    $result = $result * 100;
    return $result;

  }

  public function CurrentData($model)
  {

    $currentTem = $model::find()

              ->orderBy(['Fecha' => SORT_DESC, 'Horario'=>SORT_DESC ])
              -> one();

 
    return $currentTem;

  }


}
