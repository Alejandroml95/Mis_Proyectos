<?php

namespace app\controllers;

//Dispositivos
use app\models\DataList;
use app\models\DataListD2;
use app\models\DataListD3;
use app\models\DataListD4;

use app\models\SoundingData1;
use app\models\SampleTimeDB;


use app\models\dispositivos;

//Buscador
use app\models\FormSearch;
use app\models\FormDevice;
use app\models\FormSample;

//Buscador
use app\models\FormDownload;

//Paginación
use yii\data\Pagination;

use Yii;
use yii\helpers\BaseHtml;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;

use yii\widgets\ActiveForm;

class SiteController extends Controller
{

    private function randKey($str='', $long=0)
    {
       $key = null;
       $str = str_split($str);
       $start = 0;
       $limit = count($str)-1;
       for($x=0; $x<$long; $x++)
       {
           $key .= $str[rand($start, $limit)];
       }
       return $key;
    }

    public function actionFormulario($mensaje = null)
    {

      return $this->render("formulario", ["mensaje" => $mensaje ]);

    }

    public function actionRequest()
    { 
      $mensaje = null;
      if (isset($_REQUEST["nombre"])) {

        $mensaje = "Tu nombre es: " .$_REQUEST["nombre"];

      }

      $this->redirect(["site/formulario", "mensaje" => $mensaje] );

    }


    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'data', 'graficas', 'descargas', 'contact', 'logout'],
                'rules' => [
                    [
                        'actions' => ['index', 'data', 'graficas', 'descargas', 'contact', 'logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post']
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionLogin()
    {
          if (!Yii::$app->user->isGuest) {
  
              return $this->goHome();
  
          }
  
          $model = new LoginForm();
  
          if ($model->load(Yii::$app->request->post()) && $model->login()) {
  
              return $this->goBack();
  
          }
  
          return $this->render('login', [ 'model' => $model, ]);
      }
  
    public function actionLogout()
    {
          Yii::$app->user->logout();
  
          return $this->goHome();
      }
    
    public function CreateDevice()
    {
        
        //FormDevice es un formulario especifico para los dispositivos 
        //se encuentra en la carpeta modelos

        $formdevice = new FormDevice;
        
 
        //El array $nomdis y $dis se han creado para que cuando se cree un componentes
        //no se creen copias
        //$nomdis se rellena con los nombres de los dispositivos existentes
        // y posteriormente se comprueba si el dispositivo que se quiere Crear
        //se encuentra en el array creado ($nomdis)
        $nomdis = array();
        $dis = new dispositivos;
        $dis = $dis::find() -> all();
        foreach($dis as $row){ array_push($nomdis, $row->tipo_nom);} //Rellena array con nombres 
                                                                     //existentes

        if($formdevice->load(Yii::$app->request->post()))
        {
            if($formdevice->validate())
            {
                $tabledevice = new dispositivos;
                $tabledevice->tipo = $formdevice->tipo;
                $tabledevice->tipo_nom = $formdevice->tipo_nom;
                if ($tabledevice->tipo == "Counter") {
                    
                    $tabledevice->tipo_nom = "Counter ".$tabledevice->tipo_nom;

                } elseif ($tabledevice->tipo == "Sounding") {
                    
                    $tabledevice->tipo_nom = "Sounding ".$tabledevice->tipo_nom;

                }
                
                $tabledevice->nom = $formdevice->nom;

                if ( !(in_array( ($tabledevice->tipo_nom), $nomdis)) ) {

                    if ($tabledevice->insert())
                    {
                        
                        $formdevice->tipo = null;
                        $formdevice->tipo_nom = null;
                        $formdevice->nom = null;
                    }

                }
            }
            else
            {
                $formdevice->getErrors();
            }
        }

        return $formdevice; //Se devuelve el formulario

    }

    public function Changesampletime()
    {
        
        //FormDevice es un formulario especifico para los dispositivos 
        //se encuentra en la carpeta modelos

        $formsample = new FormSample;

        if($formsample->load(Yii::$app->request->post()))
        {
            
            if($formsample->validate())
            {
                
                $tablesampledelete = new SampleTimeDB;

                if ($formsample->id == "sounding1") {
                    $tablesampledelete::deleteAll('id = "sounding1"');
                } elseif ($formsample->id == "sounding2") {
                    $tablesampledelete::deleteAll('id = "sounding2"');
                } elseif ($formsample->id == "sounding3") {
                    $tablesampledelete::deleteAll('id = "sounding3"');
                } elseif ($formsample->id == "sounding4") {
                    $tablesampledelete::deleteAll('id = "sounding4"');
                }

                $tablesample = new SampleTimeDB;
                $tablesample->id = $formsample->id;
                $tablesample->sampletime = $formsample->sampletime;

                if ($tablesample->save())
                {
                    
                    $formsample->id = null;
                    $formsample->sampletime = null;
                }
                
            }
            else
            {
                $formsample->getErrors();
            }
        
        }

        return $formsample; //Se devuelve el formulario

    }
      
    public function actionIndex()
    {
        
        $NumberDevices = 0;

        $date = null;

        $m = null;
        $month = null;

        $arrayOpenningTimeMonth = [];
        $arrayNumberOpenningMonth = [];

        $SumOpenningTime = null;
        $NumberOfOpenning = null;

        $Counter1MonthOT = null;
        $Counter2MonthOT = null;
        $Counter3MonthOT = null;
        $Counter4MonthOT = null;

        $Counter1MonthNT = null;
        $Counter2MonthNT = null;
        $Counter3MonthNT = null;
        $Counter4MonthNT = null;

        $m =  ["January", "Febrary","March","April","May","June","July",
                    "August", "September", "October", "November", "Dicember"];

        //Mes actual
        $date = strftime( "%m", time() );
        $date = "04";

        if ( $date < 10 ) {
            $date = $date[1];
        }

        $date = (int) $date;
        $month = $m[$date - 1];

        //Contar Numero de dispositivos
        $device = new dispositivos;
        $NumberDevices = $device::find()
                            -> select('tipo') -> asArray() -> count('tipo');

        //Modelo
        $Counter1 = new DataList;
        $Counter2 = new DataListD2;
        $Counter3 = new DataListD3;
        $Counter4 = new DataListD4;

        
        $today = strftime( "%Y-%m-%d", time() );
       
        $sumOTD1 = $Counter1::SumOpenningTime($Counter1, $today);
        $sumNTD1 = $Counter1::NumberOfOpenning($Counter1, $today);

        if ($sumOTD1 == null) {
            $sumOTD1 = 0;
        }

        $sumOTD2 = $Counter1::SumOpenningTime($Counter2, $today);
        $sumNTD2 = $Counter1::NumberOfOpenning($Counter2, $today);
        if ($sumOTD2 == null) {
            $sumOTD2 = 0;
        }

        $sumOTD3 = $Counter1::SumOpenningTime($Counter3, $today);
        $sumNTD3 = $Counter1::NumberOfOpenning($Counter3, $today);
        if ($sumOTD3 == null) {
            $sumOTD3 = 0;
        }

        $sumOTD4 = $Counter1::SumOpenningTime($Counter4, $today);
        $sumNTD4 = $Counter1::NumberOfOpenning($Counter4, $today);
        if ($sumOTD4 == null) {
            $sumOTD4 = 0;
        }

        $ArraySumOT = [];
        array_push($ArraySumOT, $sumOTD1);
        array_push($ArraySumOT, $sumOTD2);
        array_push($ArraySumOT, $sumOTD3);
        array_push($ArraySumOT, $sumOTD4);

        $ArraySumNT = [];
        array_push($ArraySumNT, $sumNTD1);
        array_push($ArraySumNT, $sumNTD2);
        array_push($ArraySumNT, $sumNTD3);
        array_push($ArraySumNT, $sumNTD4);

        //Counter1 Vectores
        $arrayOpenningTimeMonthCounter1 = $Counter1::arrayOpenningTimeMonth($Counter1);
        $arrayNumberOpenningMonthCounter1 = $Counter1::arrayNumberOpenningMonth($Counter1);

        $arrayOpenningTimeMonthCounter2 = $Counter2::arrayOpenningTimeMonth($Counter2);
        $arrayNumberOpenningMonthCounter2 = $Counter2::arrayNumberOpenningMonth($Counter2);

        $arrayOpenningTimeMonthCounter3 = $Counter3::arrayOpenningTimeMonth($Counter3);
        $arrayNumberOpenningMonthCounter3 = $Counter3::arrayNumberOpenningMonth($Counter3);

        $arrayOpenningTimeMonthCounter4 = $Counter4::arrayOpenningTimeMonth($Counter4);
        $arrayNumberOpenningMonthCounter4 = $Counter4::arrayNumberOpenningMonth($Counter4);

        $Counter1MonthOT = $arrayOpenningTimeMonthCounter1[$date - 1];
        $Counter2MonthOT = $arrayOpenningTimeMonthCounter2[$date - 1];
        $Counter3MonthOT = $arrayOpenningTimeMonthCounter3[$date - 1];
        $Counter4MonthOT = $arrayOpenningTimeMonthCounter4[$date - 1];

        $Counter1MonthNT = $arrayNumberOpenningMonthCounter1[$date - 1];
        $Counter2MonthNT = $arrayNumberOpenningMonthCounter2[$date - 1];
        $Counter3MonthNT = $arrayNumberOpenningMonthCounter3[$date - 1];
        $Counter4MonthNT = $arrayNumberOpenningMonthCounter4[$date - 1];

        $formdevice = $this->CreateDevice();

        $d = new dispositivos;
        $dispositivos = $d::Order($d, "ASC");
        $nCounter = $d::NDevices($d, "Counter"); //Cuenta el número de Counters que tiene el usuario
        $nSounding = $d::NDevices($d, "Sounding");

        $Sounding1 = new SoundingData1;
        $Sounding2 = new SoundingData1;
        $Sounding3 = new SoundingData1;
        $Sounding4 = new SoundingData1;

        $CurrentDataS1 = $Sounding1::CurrentData ( $Sounding1 );
        $CurrentDataS2 = $Sounding1::CurrentData ( $Sounding1 );
        $CurrentDataS3 = $Sounding1::CurrentData ( $Sounding1 );
        $CurrentDataS4 = $Sounding1::CurrentData ( $Sounding1 );

        $ArrayCurrentData = [];
        array_push($ArrayCurrentData, $CurrentDataS1);
        array_push($ArrayCurrentData, $CurrentDataS2);
        array_push($ArrayCurrentData, $CurrentDataS3);
        array_push($ArrayCurrentData, $CurrentDataS4);
        

        //Months
        $AverageTempMonthS1 = $Sounding1::AverageMonth($Sounding1, "Temperatura");
        $AverageHumMonthS1 = $Sounding1::AverageMonth($Sounding1, "Humedad");

        $AverageTempMonthS2 = $Sounding2::AverageMonth($Sounding2, "Temperatura");
        $AverageHumMonthS2 = $Sounding2::AverageMonth($Sounding2, "Humedad");

        $AverageTempMonthS3 = $Sounding3::AverageMonth($Sounding3, "Temperatura");
        $AverageHumMonthS3 = $Sounding3::AverageMonth($Sounding3, "Humedad");

        $AverageTempMonthS4 = $Sounding4::AverageMonth($Sounding4, "Temperatura");
        $AverageHumMonthS4 = $Sounding4::AverageMonth($Sounding4, "Humedad");

        $AverageTempMonthS1 = $AverageTempMonthS1[$date - 1];
        $AverageHumMonthS1 = $AverageHumMonthS1[$date - 1];

        $AverageTempMonthS2 = $AverageTempMonthS2[$date - 1];
        $AverageHumMonthS2 = $AverageHumMonthS2[$date - 1];

        $AverageTempMonthS3 = $AverageTempMonthS3[$date - 1];
        $AverageHumMonthS3 = $AverageHumMonthS3[$date - 1];

        $AverageTempMonthS4 = $AverageTempMonthS4[$date - 1];
        $AverageHumMonthS4 = $AverageHumMonthS4[$date - 1];

        return $this->render('index',
                            ["dispositivos" => $dispositivos,
                             "nCounter" => $nCounter,
                             "nSounding" => $nSounding,
                            
                             "NumberDevices" => $NumberDevices,

                                "ArraySumOT" => $ArraySumOT,
                                "ArraySumNT" => $ArraySumNT,

                                "arrayOpenningTimeMonth" => $arrayOpenningTimeMonth,
                                "arrayNumberOpenningMonth" => $arrayNumberOpenningMonth,

                                "Counter1MonthOT" => $Counter1MonthOT,
                                "Counter2MonthOT" => $Counter2MonthOT,
                                "Counter3MonthOT" => $Counter3MonthOT,
                                "Counter4MonthOT" => $Counter4MonthOT,

                                "Counter1MonthNT" => $Counter1MonthNT,
                                "Counter2MonthNT" => $Counter2MonthNT,
                                "Counter3MonthNT" => $Counter3MonthNT,
                                "Counter4MonthNT" => $Counter4MonthNT,
                                "month" => $month,
                                "date" => $date,

                                'formdevice' => $formdevice,

                                "ArrayCurrentData" => $ArrayCurrentData,

                                "AverageTempMonthS1" => $AverageTempMonthS1,
                                "AverageTempMonthS2" => $AverageTempMonthS2,
                                "AverageTempMonthS3" => $AverageTempMonthS3,
                                "AverageTempMonthS4" => $AverageTempMonthS4,
                                
                                "AverageHumMonthS1" => $AverageHumMonthS1,
                                "AverageHumMonthS2" => $AverageHumMonthS2,
                                "AverageHumMonthS3" => $AverageHumMonthS3,
                                "AverageHumMonthS4" => $AverageHumMonthS4,
                                

                            ]);
    }

    //Funcion que realizará todas las acciones de una vista de lista de datos
    public function DataTable($model, $view)
    {
        $form = new FormSearch;
        $searchFD = null;
        $searchED = null;

        $FilterDayFD = null;
        $FilterDayED = null;

        $tablemodel = $model;

        if ($form -> load(Yii::$app -> request ->get() )) {

        if ($form ->validate()) {

            $searchFD = Html::encode($form -> FirstDate);
            $searchED = Html::encode($form -> EndDate);

            if ($searchFD == null) {

            $date = strftime( "%Y-%m-%d", time() );
            $searchFD = $date;

            $FilterDayFD = $tablemodel::FilterDay($searchFD);

            } else {

            $FilterDayFD = $tablemodel::FilterDay($searchFD);

            }

            if ($searchED == null) {

            $FilterDayED = "...";

            } else {

            $FilterDayED = $tablemodel::FilterDay($searchED);

            }

            $table = $tablemodel::OrderByCondition($tablemodel, "DES", "FechaApertura", "HorarioApertura", $searchFD, $searchED);

            $count = clone $table;
            $pages = new Pagination([

                    "pageSize" => 10,
                    "totalCount" => $count -> count(),

            ]);


            $model = $table
                    -> offset($pages -> offset)
                    -> limit($pages -> limit)
                    -> all();

        } else {

                $form -> getErrors();

        }

        } else {

        $date = strftime( "%Y-%m-%d", time() );
        $searchFD = $date;

        $FilterDayFD = $tablemodel::FilterDay($searchFD);
        $FilterDayED = "...";
        $table = $tablemodel::find() ->orderBy(['FechaApertura' => SORT_DESC, 'HorarioApertura'=>SORT_DESC ]);

        $count = clone $table;
        $pages = new Pagination([

                "pageSize" => 10,
                "totalCount" => $count -> count(),

        ]);


        $model = $table
                    -> offset ($pages -> offset)
                    -> limit($pages -> limit)
                    -> all();

        }

        $formdevice = $this->CreateDevice();

        return $this->render( $view, ["model" => $model, "FilterDayFD" => $FilterDayFD,
                            "FilterDayED" => $FilterDayED,
                            "form" => $form, "searchFD" => $searchFD,
                            'formdevice' => $formdevice,
                
                            "searchED" => $searchED, "pages" => $pages]);
    }

    public function SoundingData($model, $view)
    {
        $form = new FormSearch;
        $searchFD = null;
        $searchED = null;

        $FilterDayFD = null;
        $FilterDayED = null;

        $tablemodel = $model;

        if ($form -> load(Yii::$app -> request ->get() )) {

        if ($form ->validate()) {

            $searchFD = Html::encode($form -> FirstDate);
            $searchED = Html::encode($form -> EndDate);

            if ($searchFD == null) {

            $date = strftime( "%Y-%m-%d", time() );
            $searchFD = $date;

            $FilterDayFD = $tablemodel::FilterDay($searchFD);

            } else {

            $FilterDayFD = $tablemodel::FilterDay($searchFD);

            }

            if ($searchED == null) {

            $FilterDayED = "...";

            } else {

            $FilterDayED = $tablemodel::FilterDay($searchED);

            }

            $table = $tablemodel::OrderByCondition($tablemodel, "DES", "Fecha", "Horario", $searchFD, $searchED);

            $count = clone $table;
            $pages = new Pagination([

                    "pageSize" => 10,
                    "totalCount" => $count -> count(),

            ]);


            $model = $table
                    -> offset($pages -> offset)
                    -> limit($pages -> limit)
                    -> all();

        } else {

                $form -> getErrors();

        }

        } else {

        $date = strftime( "%Y-%m-%d", time() );
        $searchFD = $date;

        $FilterDayFD = $tablemodel::FilterDay($searchFD);
        $FilterDayED = "...";
        $table = $tablemodel::find() ->orderBy(['Fecha' => SORT_DESC, 'Horario'=>SORT_DESC ]);

        $count = clone $table;
        $pages = new Pagination([

                "pageSize" => 10,
                "totalCount" => $count -> count(),

        ]);


        $model = $table
                    -> offset ($pages -> offset)
                    -> limit($pages -> limit)
                    -> all();

        }

        $formdevice = $this->CreateDevice();

        return $this->render( $view, ["model" => $model, "FilterDayFD" => $FilterDayFD,
                            "FilterDayED" => $FilterDayED,
                            "form" => $form, "searchFD" => $searchFD,
                            'formdevice' => $formdevice,
                
                            "searchED" => $searchED, "pages" => $pages]);
    }

    public function actionCounterdata1()
    {
        $Counter = new DataList;
        return $this->DataTable($Counter, "counterdata1");
    }

    public function actionCounterdata2()
    {
        $Counter = new DataListD2;
        return $this->DataTable($Counter, "counterdata2");
    }

    public function actionCounterdata3()
    {
        $Counter = new DataListD3;
        return $this->DataTable($Counter, "counterdata3");
    }

    public function actionCounterdata4()
    {
        $Counter = new DataListD4;
        return $this->DataTable($Counter, "counterdata4");
    }
    
    //Funcion que realizará todas las acciones de una vista de graficas
    public function counterchart( $model, $view)
    {
         //Variables de Buscador
         $formchart = new FormSearch;
         $searchFD = null;
 
         //Pestaña Day
         $FilterDay = null;
         $tableDay = null; //$tableDay será la encargada de almacenar los datos de la tabla de la sección del "Day"
 
         $SumOpenningTime = null;
         $NumberOfOpenning = null;
 
         //Gráfica Week
         $arrayOpenningTime = [];
         $arrayNumberOpenning = [];
         $Days = [];
 
         //Gráfica Months
         $arrayOpenningTimeMonth = [];
         $arrayNumberOpenningMonth = [];
         $tableMonth = null;//tablaMonth se encarga de almacenar los datos del mes
 
         //Modelo -> Se Obtendrá la tabla y a su vez los datos
         $Counter1 = $model;
 
         //Validamos los datos que se quieren filtrar en la tabla
         if ($formchart -> load(Yii::$app -> request ->get() )) {
 
         if ($formchart ->validate()) {
 
             $searchFD = Html::encode($formchart -> FirstDate);
             //Pestaña Day
 
             if ($searchFD == null) {
             $today = getdate();
             $date = strftime( "%Y-%m-%d", time() );
             $searchFD = $date;
 
             }
 
             //Para mostrar en la vista una fecha con formato
             $FilterDay = $Counter1::FilterDay($searchFD);
 
             //$tableTime se utilizará para obtener los valores del eje X de la tabla
 
             //Las siguientes variables almacerán los filtros que quiere hacer el usuario
             // para posteriormente pasar estas variables a la vista
             $tableTime = $Counter1::XasisTime($Counter1, $searchFD);
 
             $tableDay = $Counter1::OpennigTime($Counter1, $searchFD);
 
             $SumOpenningTime = $Counter1::SumOpenningTime($Counter1, $searchFD);
 
             $NumberOfOpenning = $Counter1::NumberOfOpenning($Counter1, $searchFD);
 
             //Week
             $Day= $Counter1::arrayDay($Counter1, $searchFD);
             $arrayOpenningTime = $Counter1::arrayOpennigTime($Counter1, $searchFD);
             $arrayNumberOpenning = $Counter1::arrayNumberOpenning($Counter1, $searchFD);
 
             //Months
 
             $arrayOpenningTimeMonth = $Counter1::arrayOpenningTimeMonth($Counter1);
             $arrayNumberOpenningMonth = $Counter1::arrayNumberOpenningMonth($Counter1);
 
         } else {
 
             $formchart -> getErrors();
 
         }
 
         } else {
 
             $today = getdate();
             $date = strftime( "%Y-%m-%d", time() );
             $searchFD = $date;
 
             //Para mostrar en la vista una fecha con formato
             $FilterDay = $Counter1::FilterDay($searchFD);
 
             //Day
             $tableTime = $Counter1::XasisTime($Counter1, $date);
 
             $tableDay = $Counter1::OpennigTime($Counter1, $date);
 
             $SumOpenningTime = $Counter1::SumOpenningTime($Counter1, $date);
 
             $NumberOfOpenning = $Counter1::NumberOfOpenning($Counter1, $date);
 
             //Week
             $Day= $Counter1::arrayDay($Counter1, $date);
             $arrayOpenningTime = $Counter1::arrayOpennigTime($Counter1, $date);
             $arrayNumberOpenning = $Counter1::arrayNumberOpenning($Counter1, $date);
 
             //Months
             $arrayOpenningTimeMonth = $Counter1::arrayOpenningTimeMonth($Counter1);
             $arrayNumberOpenningMonth = $Counter1::arrayNumberOpenningMonth($Counter1);
         }
 
         $formdevice = $this->CreateDevice();
 
         return $this->render( $view, ["tableDay" => $tableDay,
                             "FilterDay" => $FilterDay,
                             "tableTime" => $tableTime,
                             "SumOpenningTime" => $SumOpenningTime,
                             "NumberOfOpenning" => $NumberOfOpenning,
 
                             "Day" => $Day,
                             "arrayOpenningTime" => $arrayOpenningTime,
                             "arrayNumberOpenning" => $arrayNumberOpenning,
 
                             "arrayOpenningTimeMonth" => $arrayOpenningTimeMonth,
                             "arrayNumberOpenningMonth" => $arrayNumberOpenningMonth,
 
                             'formdevice' => $formdevice,
                             "formchart" => $formchart,
                             "searchFD" => $searchFD] );
    }

    public function actionCounter1chart()
    {

        $Counter = new DataList;
        return $this->counterchart($Counter, "counter1chart");

    }

    public function actionCounter2chart()
    {

        $Counter = new DataListD2;
        return $this->counterchart($Counter, "counter2chart");

    }

    public function actionCounter3chart()
    {

        $Counter = new DataListD3;
        return $this->counterchart($Counter, "counter3chart");

    }
    
    public function actionCounter4chart()
    {

        $Counter = new DataListD4;
        return $this->counterchart($Counter, "counter4chart");

    }

    public function download($id, $view)
    {
        //array
        $NameFiles = array();

        $CounterId = array();
        $CounterMonth = array();
        $CounterYear = array();

        $month =  ["January", "Febrary","March","April","May","June","July",
                    "August", "September", "October", "November", "Dicember"];

        $files=\yii\helpers\FileHelper::findFiles('archivos/');

        if (isset($files[0])) {

            foreach ($files as $index => $file) {

                $nameFicheiro = substr($file, strrpos($file, '/') + 2);

                if ($nameFicheiro[0] == "c" && $nameFicheiro[7] == $id) {

                    $year = $nameFicheiro[9] . $nameFicheiro[10] .$nameFicheiro[11] .$nameFicheiro[12];

                    $m = $nameFicheiro[14] . $nameFicheiro[15];
                    $m = (int) $m;
                    $m = $m - 1;

                    array_push($CounterId, $nameFicheiro[7]);
                    array_push($CounterMonth, $month[$m]); 
                    array_push($CounterYear, $year); 
                    
                    array_push($NameFiles, $nameFicheiro);
                }

            }
        } else {
            echo "There are no files available for download.";
        }

        $formdevice = $this->CreateDevice();

         return $this->render( $view, [
                            "NameFiles" => $NameFiles, 
                            "CounterId" => $CounterId, 
                            "CounterMonth" => $CounterMonth, 
                            "CounterYear" => $CounterYear,
                            "formdevice" => $formdevice,] );
    }

    public function actionCounter1download()
    {

        $id = "1";
        return $this->download($id, "counter1download");

    }

    public function actionCounter2download()
    {

        $id = "2";
        return $this->download($id, "counter2download");

    }

    public function actionCounter3download()
    {

        $id = "3";
        return $this->download($id, "counter3download");

    }

    public function actionCounter4download()
    {

        $id = "4";
        return $this->download($id, "counter4download");

    }



    public function actionConfigdispositivo()
    {

        $d = new dispositivos;
        
        $dispositivos = $d::Order($d, "ASC");
        $nCounter = $d::NDevices($d, "Counter"); //Cuenta el número de Counters que tiene el usuario
        $nSounding = $d::NDevices($d, "Sounding");

        $formdevice = $this->CreateDevice();

        return $this->render("configdispositivo", ['formdevice' => $formdevice,
                                                    'dispositivos' => $dispositivos,
                                                    'nCounter' => $nCounter,
                                                    'nSounding' => $nSounding
                                                    ]);

    }
    //La siguiente acción se ejecuta en la vista ConfDipsoitivos
    public function actionDelete()
    {
        if(Yii::$app->request->post())
        {
            $tipo_nom = Html::encode($_POST["tipo_nom"]);
            if( $tipo_nom == "Counter 1" || $tipo_nom == "Counter 2" ||
                $tipo_nom == "Counter 3"|| $tipo_nom == "Counter 4" || 
                $tipo_nom == "Sounding 1" || $tipo_nom == "Sounding 2" ||
                $tipo_nom == "Sounding 3"|| $tipo_nom == "Sounding 4")
            {
                if(dispositivos::deleteAll("tipo_nom=:tipo_nom", [":tipo_nom" => $tipo_nom]))
                {
                    echo "The $tipo_nom delete, redireccionando ...";
                    echo "<meta http-equiv='refresh' content='1; ".Url::toRoute("site/configdispositivo")."'>";
                }
                else
                {

                    echo "<meta http-equiv='refresh' content='1; ".Url::toRoute("site/configdispositivo")."'>";
                }
            }
            else
            {
                echo "No se ha enviado la petición";
                echo "<meta http-equiv='refresh' content='3; ".Url::toRoute("site/configdispositivo")."'>";
            }
        }
        else
        {
            return $this->redirect(["site/configdispositivo"]);
        }
    }

    //La siguiente funcion almacena el procesamiento de las vistas 
    //de las sondas de graficas
    public function Soundingchart( $model, $view)
    {  

        //Variables de Buscador
        $formchart = new FormSearch;
        $searchFD = null;   
        //String para mostrar el día filtrado en la vista
        $FilterDay = null;

        $TableTime = null; //Eje X de la tabla de "Day" de Horarios
        $TemperatureDay = null; //Eje Y de la tabla "Day" Temperaturas
        $AverageTemDay = null;
 
        $MaxTemDay = null;
        $MinTemDay = null;

        $Days = null;
        $AverageTempWeek = null;

        //Modelo -> Se Obtendrá la tabla y a su vez los datos
        $Sounding = $model;
 
        //Validamos los datos que se quieren filtrar en la tabla
        if ($formchart -> load(Yii::$app -> request ->get() )) {
 
             if ($formchart ->validate()) {
            
                //Conocer cual es el día que el usuario quiere filtrar
                 $searchFD = Html::encode($formchart -> FirstDate);

                //Cuando se carga la web y la variable $searchFD es null
                if ($searchFD == null) {
                    $today = getdate();
                    $date = strftime( "%Y-%m-%d", time() );
                    $searchFD = $date;   
                }
 
                //Para mostrar en la vista la fecha filtrada por el usuario con formato
                $FilterDay = $Sounding::FilterDay($searchFD);
  
                //$tableTime se utilizará para obtener los valores del eje X de la tabla
 
                //Las siguientes variables almacenan los datos del dia actual y 
                //el dia filtrado por el usuario
                $TableTime = $Sounding::XasisTime($Sounding, $searchFD); //Eje X tabla "Day"
                $TemperatureDay = $Sounding::DataDay($Sounding, $searchFD, "Temperatura"); //Eje Y tabla "Day"
                $HumidityDay = $Sounding::DataDay($Sounding, $searchFD, "Humedad"); //Eje Y tabla "Day"

                $AverageTempDay = $Sounding::AverageDay($Sounding, $searchFD, "Temperatura"); //Media de temperatura del dia actual
                $MaxTemDay = $Sounding::MaxDay($Sounding, $searchFD, "Temperatura"); //Max de temperatura del dia actual
                $MinTemDay = $Sounding::MinDay($Sounding, $searchFD, "Temperatura"); //Min de temperatura del dia actual

                $AverageHumDay = $Sounding::AverageDay($Sounding, $searchFD, "Humedad"); //Media de humedad del dia actual
                $MaxHumDay = $Sounding::MaxDay($Sounding, $searchFD, "Humedad"); //Max de humedad del dia actual
                $MinHumDay = $Sounding::MinDay($Sounding, $searchFD, "Humedad"); //Min de humedad del dia actual

                //Las siguientes variables almacenan datos del dia actual y siete dias anteriores
                $Days = $Sounding::arrayDay($Sounding, $searchFD); //Eje X tabla "Week"
                $AverageTempWeek = $Sounding::AverageWeek($Sounding, $searchFD, "Temperatura");
                $AverageHumWeek = $Sounding::AverageWeek($Sounding, $searchFD, "Humedad");
                 
                
         } else {
 
             $formchart -> getErrors();
 
         }
 
         } else {
 
             $today = getdate();
             $date = strftime( "%Y-%m-%d", time() );
 
            //Para mostrar en la vista la fecha filtrada por el usuario con formato
            $FilterDay = $Sounding::FilterDay($date);
  
            //$tableTime se utilizará para obtener los valores del eje X de la tabla

            //Las siguientes variables almacenan los datos del dia actual y 
            //el dia filtrado por el usuario
            $TableTime = $Sounding::XasisTime($Sounding, $date); //Eje X tabla "Day"
            $TemperatureDay = $Sounding::DataDay($Sounding, $date, "Temperatura"); //Eje Y tabla "Day"
            $HumidityDay = $Sounding::DataDay($Sounding, $date, "Humedad"); //Eje Y tabla "Day"

            $AverageTempDay = $Sounding::AverageDay($Sounding, $date, "Temperatura"); //Media de temperatura del dia actual
            $MaxTemDay = $Sounding::MaxDay($Sounding, $date, "Temperatura"); //Max de temperatura del dia actual
            $MinTemDay = $Sounding::MinDay($Sounding, $date, "Temperatura"); //Min de temperatura del dia actual

            $AverageHumDay = $Sounding::AverageDay($Sounding, $date, "Humedad"); //Media de humedad del dia actual
            $MaxHumDay = $Sounding::MaxDay($Sounding, $date, "Humedad"); //Max de humedad del dia actual
            $MinHumDay = $Sounding::MinDay($Sounding, $date, "Humedad"); //Min de humedad del dia actual

            //Las siguientes variables almacenan datos del dia actual y siete dias anteriores
            $Days = $Sounding::arrayDay($Sounding, $date); //Eje X tabla "Week"
            $AverageTempWeek = $Sounding::AverageWeek($Sounding, $date, "Temperatura");
            $AverageHumWeek = $Sounding::AverageWeek($Sounding, $date, "Humedad");
            
            
         }
 
         $formdevice = $this->CreateDevice();
         $formsample = $this->Changesampletime();
         

         $sampleTime = new SampleTimeDB;
         $sampleTime = $sampleTime::SampleTime( $sampleTime, "sounding1" );
         $CurrentData = $Sounding::CurrentData ( $Sounding );

         $percemtageTem = $Sounding::Percentage ( $CurrentData -> Temperatura, 80, -40 ); //(value, max, min)
         $percemtageHum = $Sounding::Percentage ( $CurrentData -> Humedad, 80, 0 ); //(value, max, min)

         //Month
         $AverageTempMonth = $Sounding::AverageMonth($Sounding, "Temperatura");
         $AverageHumMonth = $Sounding::AverageMonth($Sounding, "Humedad");

         return $this->render( $view, ["FilterDay" => $FilterDay,

                            "TableTime" => $TableTime,
                            "TemperatureDay" => $TemperatureDay,
                            "HumidityDay" => $HumidityDay,
                            "percemtageTem" => $percemtageTem,
                            "percemtageHum" => $percemtageHum,
                            "CurrentData" => $CurrentData,
                            

                            "AverageTemDay" => $AverageTempDay,
                            "MaxTemDay" => $MaxTemDay,
                            "MinTemDay" => $MinTemDay,

                            "AverageHumDay" => $AverageHumDay,
                            "MaxHumDay" => $MaxHumDay,
                            "MinHumDay" => $MinHumDay,

                            "Days" => $Days,
                            "AverageTempWeek" => $AverageTempWeek,
                            "AverageHumWeek" => $AverageHumWeek,

                            "AverageTempMonth" => $AverageTempMonth,
                            "AverageHumMonth" => $AverageHumMonth,
                            
                            "formsample" => $formsample,
                            "sampleTime" => $sampleTime,
                            
                            "formdevice" => $formdevice,
                            "formchart" => $formchart,
                            "searchFD" => $searchFD] );
    
    }

    public function actionSoundingdata1()
    {
        $Sounding = new SoundingData1;
        return $this->SoundingData($Sounding, "soundingdata1");
    }

    public function actionSoundingdata2()
    {
        $Sounding = new SoundingData1;
        return $this->DataTable($Sounding, "soundingdata2");
    }

    public function actionSoundingdata3()
    {
        $Sounding = new SoundingData1;
        return $this->DataTable($Sounding, "soundingdata3");
    }

    public function actionSoundingdata4()
    {
        $Sounding = new SoundingData1;
        return $this->DataTable($Sounding, "soundingdata4");
    }

    public function actionSounding1chart()
    {

        $Sounding = new SoundingData1;
        return $this->Soundingchart($Sounding, "sounding1chart");

    }

    public function actionSounding2chart()
    {

        $Sounding2 = new SoundingData1;
        return $this->Soundingchart($Sounding2, "sounding2chart");

    }

    public function actionSounding3chart()
    {

        $Sounding3 = new SoundingData1;
        return $this->Soundingchart($Sounding3, "sounding3chart");

    }

    public function actionSounding4chart()
    {

        $Sounding4 = new SoundingData1;
        return $this->Soundingchart($Sounding4, "sounding4chart");

    }

    
    public function downloadsounding($device,$id, $view)
    {
        //array
        $NameFiles = array();

        $Id = array();
        $Month = array();
        $Year = array();

        $month =  ["January", "Febrary","March","April","May","June","July",
                    "August", "September", "October", "November", "Dicember"];

        $files=\yii\helpers\FileHelper::findFiles('archivos/');

        if (isset($files[0])) {

            foreach ($files as $index => $file) {

                $nameFicheiro = substr($file, strrpos($file, '/') + 2);

                if ($nameFicheiro[0] == $device && $nameFicheiro[8] == $id) {

                    $year = $nameFicheiro[10] . $nameFicheiro[11] .$nameFicheiro[12] .$nameFicheiro[13];

                    $m = $nameFicheiro[15] . $nameFicheiro[16];
                    $m = (int) $m;
                    $m = $m - 1;

                    array_push($Id, $nameFicheiro[8]);
                    array_push($Month, $month[$m]); 
                    array_push($Year, $year); 
                    
                    array_push($NameFiles, $nameFicheiro);
                }
                

            }
        } else {
            echo "There are no files available for download.";
        }

        $formdevice = $this->CreateDevice();

         return $this->render( $view, [
                            "NameFiles" => $NameFiles, 
                            "Id" => $Id, 
                            "Month" => $Month, 
                            "Year" => $Year,
                            "formdevice" => $formdevice,] );
    }

    public function actionSounding1download()
    {

        $id = "1";
        return $this->downloadsounding("s",$id, "sounding1download");

    }

    public function actionSounding2download()
    {

        $id = "2";
        return $this->downloadsounding("s",$id, "sounding2download");

    }

    public function actionSounding3download()
    {

        $id = "3";
        return $this->downloadsounding("s",$id, "sounding3download");

    }

    public function actionSounding4download()
    {

        $id = "4";
        return $this->downloadsounding("s",$id, "sounding4download");

    }

}