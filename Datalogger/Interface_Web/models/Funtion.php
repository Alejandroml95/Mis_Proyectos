<?php

namespace app\models;
use Yii;
use yii\db\ActiveRecord;
use app\models\Funtion;

class Funtion extends ActiveRecord{

    public function XasisTime($model, $Search)
    {

      $XasisTime = $model::find()

              -> where(["LIKE", "FechaApertura", $Search ])
              -> select('HorarioApertura') -> asArray() -> all();

      $XasisTime = array_map('end', $XasisTime); //Eliminamos los array dentrto del array
      $XasisTime = array_values($XasisTime);

      return $XasisTime;

    }

    public function OpennigTime($model, $Search)
    {

      //Filtramos los datos pasados por el usuarios
      $OpenningTime = $model::find()

               -> where(["LIKE", "FechaApertura", $Search ])
               -> select('TiempoApertura') -> asArray() -> all();

      $OpenningTime = array_map('end', $OpenningTime);
      $OpenningTime = array_values($OpenningTime);
      $OpenningTime = array_map('intval', $OpenningTime);

      return $OpenningTime;

    }

    public function SumOpenningTime($model, $Search)
    {

      $SumOpenningTime = $model::find()

               -> where(["LIKE", "FechaApertura", $Search ])
               -> select('TiempoApertura') -> asArray() -> sum('TiempoApertura');

      return $SumOpenningTime;

    }

    public function NumberOfOpenning($model, $Search)
    {

      $NumberOfOpenning = $model::find()

                -> where(["LIKE", "FechaApertura", $Search ])
                -> select('TiempoApertura') -> asArray() -> count('TiempoApertura');

      return $NumberOfOpenning;

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

    public function arrayOpennigTime($model, $Search)
    {

      for ($i = 7; $i >= 0 ; $i--) {

        $strnumber = (string)$i;
        $str = '-'.$strnumber.' day';

        $LastDay = strtotime ( $str , strtotime ( $Search ) ) ;
        $LastDay = date ( 'Y-m-d' , $LastDay );

        $arrayOpenningTime[7 - $i] = $model::find()

               -> where(["LIKE", "FechaApertura", $LastDay ])
               -> select('TiempoApertura') -> asArray() -> sum('TiempoApertura');

        $arrayOpenningTime[7 - $i] = (int)$arrayOpenningTime[7 - $i];

      }

      return $arrayOpenningTime;

    }

    public function arrayNumberOpenning($model, $Search)
    {

      for ($i = 7; $i >= 0 ; $i--) {

        $strnumber = (string)$i;
        $str = '-'.$strnumber.' day';

        $LastDay = strtotime ( $str , strtotime ( $Search ) ) ;
        $LastDay = date ( 'Y-m-d' , $LastDay );

        $arrayNumberOpenning[7 - $i] = $model::find()

               -> where(["LIKE", "FechaApertura", $LastDay ])
               -> select('TiempoApertura') -> asArray() -> count('TiempoApertura');

        $arrayNumberOpenning[7 - $i] = (int)$arrayNumberOpenning[7 - $i];

      }

      return $arrayNumberOpenning;

    }

    public function arrayOpenningTimeMonth($model)
    {

      for ($i = 0 ; $i < 12 ; $i++) {

        $strnumber = (string)$i;
        $str = '+'.$strnumber.' month';
        $date = strftime( "%Y", time() );
        $date = $date."-1";

        $LastMonth = strtotime ( $str , strtotime ( $date ) ) ;
        $LastMonth = date ( 'Y-m' , $LastMonth );

        $arrayOpenningTimeMonth[$i] = $model::find()

               -> where(["LIKE", "FechaApertura", $LastMonth ])
               -> select('TiempoApertura') -> asArray() -> sum('TiempoApertura');

        $arrayOpenningTimeMonth[$i] = (int)$arrayOpenningTimeMonth[$i];

      }

      return $arrayOpenningTimeMonth;

    }

    public function arrayNumberOpenningMonth($model)
    {

      for ($i = 0 ; $i < 12 ; $i++) {

        $strnumber = (string)$i;
        $str = '+'.$strnumber.' month';
        $date = strftime( "%Y", time() );
        $date = $date."-1";

        $LastMonth = strtotime ( $str , strtotime ( $date ) ) ;
        $LastMonth = date ( 'Y-m' , $LastMonth );

        $arrayNumberOpenningMonth[$i] = $model::find()

               -> where(["LIKE", "FechaApertura", $LastMonth ])
               -> select('TiempoApertura') -> asArray() -> count('TiempoApertura');

        $arrayNumberOpenningMonth[$i] = (int)$arrayNumberOpenningMonth[$i];

      }

      return $arrayNumberOpenningMonth;

    }

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

    public function NDevices($model, $NameDevice)
    {

      $NDevice = $model::find()

                -> where(["LIKE", "tipo", $NameDevice ])
                -> select('tipo') -> asArray() -> count('tipo');

      return $NDevice;

    }

    public function Order($model, $direction)
    {
      if ($direction == "ASC") {

        $dispositivos = $model::find() ->orderBy(['tipo_nom' => SORT_ASC ]) -> all();

      } elseif ($direction == "DESC") {

        $dispositivos = $model::find() ->orderBy(['tipo_nom' => SORT_DESC ]) -> all();
      
      }

      return $dispositivos;

    }

    public function OrderByCondition($model, $direction, $Colum1, $Colum2, $Day1, $Day2)
    {
      if ($direction == "ASC") {

        $table = $model::find()

                    -> orwhere(["between", $Colum1, $searchFD, $searchED ])
                    -> orWhere(["like", $Colum1, $searchFD])
                    ->orderBy([$Colum1 => SORT_ASC, $Colum2 => SORT_ASC ]);

      } elseif ($direction == "DESC") {

        $table = $model::find()
                        -> orwhere(["between", $Colum1, $searchFD, $searchED ])
                        -> orWhere(["like", $Colum1, $searchFD])
                        ->orderBy([$Colum1 => SORT_DESC, $Colum2 => SORT_DESC ]);
      
      }

      return $dispositivos;

    }

    

}
