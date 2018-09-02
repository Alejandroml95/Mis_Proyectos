<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use miloschuman\highcharts\Highcharts;

use yii\widgets\ActiveForm;

use yii\widgets\LinkPager;
use kartik\date\DatePicker;
use yii\helpers\Url;
use yii\db\ActiveRecord;

use yii\web\JsExpression;


$this->title = 'Sounding 2';
$this->params['breadcrumbs'][] = $this->title;

?>

<br><br>

<div class="row">

<div class="col-md-3">
  <div class="info-box bg-yellow-gradient">
    <!-- Apply any bg-* class to to the icon to color it -->
    <span class="info-box-icon"><i class="fa fa-calendar"></i></span>
    <div class="info-box-content">
      <span class="info-box-text">Filter Day</span>
      <span class="info-box-number"><?= $FilterDay ?></span>
    </div><!-- /.info-box-content -->
  </div><!-- /.info-box -->

</div>


<div class="col-md-3">
<div class="info-box bg-teal">
  <span class="info-box-icon"><i class="fa fa-sun-o"></i></span>
  <div class="info-box-content">
    <span class="info-box-text">Temperature</span>
    <span class="info-box-number"><?= $CurrentData -> Temperatura ?> ºC</span>
    <div class="progress">
        <div class="progress-bar" style="width: <?=$percemtageTem?>%"></div>
      </div>
      <span class="progress-description">
        
      </span>
    </div>
    <!-- /.info-box-content -->
  </div>
</div>

<div class="col-md-3">
<div class="info-box bg-blue">
  <span class="info-box-icon"><i class="fa fa-cloud"></i></span>
  <div class="info-box-content">
    <span class="info-box-text">Humidity</span>
    <span class="info-box-number"><?= $CurrentData -> Humedad ?> %</span>
    <div class="progress">
        <div class="progress-bar" style="width: <?=$percemtageHum?>%"></div>
      </div>
      <span class="progress-description">
        
      </span>
    </div>
    <!-- /.info-box-content -->
  </div>
</div>

<div class="col-md-2">
  <div class="info-box bg-green-gradient">
      <!-- Apply any bg-* class to to the icon to color it -->
    <span class="info-box-icon"><i class="fa fa-hourglass-2"></i></span>
    <div class="info-box-content">
      <span class="info-box-text">T. Sample</span>
      <span class="info-box-number"> <?= $sampleTime ?> Minutes </span>
    </div><!-- /.info-box-content -->
  </div><!-- /.info-box -->
</div>

<div class="col-md-1">
  <a href='javascript::;'>
    <div class="menu-info">
    <!-- Button trigger modal -->
      <button type="button" class="btn btn-block bg-gray" data-toggle="modal" data-target="#filter">
      <i class="fa fa-filter"></i>  Filter
      </button>
    </div>
  </a>
</div>

<br><br><br>

<div class="col-md-1">
  <a href='javascript::;'>
    <div class="menu-info">
    <!-- Button trigger modal -->
      <button type="button" class="btn btn-block bg-gray" data-toggle="modal" data-target="#sample">
      <i class="fa fa-gear"></i> Setting
      </button>
    </div>
  </a>
</div>

</div>


<div class="row">

  <div class="col-md-12">
    <!-- AREA CHART -->
    <div class="box box-info">
      <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-bar-chart"></i> Day Chart</h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
          </button>
          <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
      </div>
      <div class="box-body">
        <div class="chart">

          <div style="height:400px">

          <?php

          echo Highcharts::widget([

               'options' => [
                  'title' => ['text' => ''],
                  'xAxis' => [
                     'categories' => $TableTime,
                     'title' => ['text' => 'TIME']
                  ],
                  'yAxis' => [
                     'title' => ['text' => 'Temperature']
                  ],
                  'series' => [
                     [ 'type' => 'column',
                       'color' => '#1AC4D5',
                       'name' => 'Temperature',
                       'data' => $TemperatureDay, '#0F4EEA',

                      ],

                      [ 'type' => 'column',
                       'color' => '#1B9287',
                       'name' => 'Humidity',
                       'data' => $HumidityDay, '#0F4EEA',

                      ],

                  ]

               ]
            ]);

          ?>

          </div>
        </div>
      </div>
      <!-- /.box-body -->
      <div class="box-footer">
              <div class="row">
                <div class="col-md-2">
                  <div class="description-block border-right">
                    <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> <?= $AverageTemDay ?> ºC</span>
                    <h5 class="description-header"> Average Temperature </h5>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-md-2">
                  <div class="description-block border-right">
                    <span class="description-percentage text-red"><i class="fa fa-caret-up"></i> <?= $MaxTemDay ?> ºC</span>
                    <h5 class="description-header"> Max Temperature </h5>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-md-2">
                  <div class="description-block border-right">
                    <span class="description-percentage text-yellow"><i class="fa fa-caret-down"></i> <?= $MinTemDay ?> ºC</span>
                    <h5 class="description-header"> Min Temperature </h5>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-md-2">
                  <div class="description-block border-right">
                    <span class="description-percentage text-green"><i class="fa fa-caret-down"></i> <?= $AverageHumDay ?> ºC</span>
                    <h5 class="description-header"> Average Humidity </h5>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-md-2">
                  <div class="description-block border-right">
                    <span class="description-percentage text-red"><i class="fa fa-caret-down"></i> <?= $MaxHumDay ?> ºC</span>
                    <h5 class="description-header"> Max Humidity </h5>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-md-2">
                  <div class="description-block border-right">
                    <span class="description-percentage text-yellow"><i class="fa fa-caret-down"></i> <?= $MinHumDay ?> ºC</span>
                    <h5 class="description-header"> Min Humidity </h5>
                  </div>
                  <!-- /.description-block -->
                </div>
              </div>
              <!-- /.row -->
            </div>

    </div>


  </div>
  
  <!-- /.col (LEFT) -->
  <div class="col-md-6">
    <!-- LINE CHART -->
    <div class="box box-success">
      <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-bar-chart"></i> Week Chart</h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
          </button>
          <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
      </div>
      <div class="box-body">
        <div class="chart">
          <div style="height:400px">

            <?php

            echo Highcharts::widget([

               'options' => [
                  'title' => ['text' => 'Time'],
                  'xAxis' => [
                     'categories' => $Days,
                     'name' => 'Date'
                  ],
                  'yAxis' => [
                     'title' => ['text' => 'Average Data']
                  ],
                  'series' => [

                    [ 'type' => 'column',
                      'color' => '#46A457',
                      'name' => 'Average Temperature',
                      'data' => $AverageTempWeek ],
                      
                    [ 'type' => 'column',
                      'color' => '#7EF794',
                      'name' => 'Average Humidity',
                      'data' => $AverageHumWeek ],
                  
                     

                  ]
               ]
            ]);

            ?>

          </div>
        </div>
      </div>
      <!-- /.box-body -->
    </div>
  </div>

  <!-- /.col (RIGHT) -->

  <div class="col-md-6">
    <!-- LINE CHART -->
    <div class="box box-warning">
      <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-bar-chart"></i> Month Chart</h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
          </button>
          <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
      </div>
      <div class="box-body">
        <div class="chart">
          <div style="height:400px">

            <?php

            echo Highcharts::widget([

               'options' => [
                  'title' => ['text' => 'Time'],
                  'xAxis' => [
                     'categories' => ["January", "Febrary","March","April","May","June","July","August", "September", "October", "November", "Dicember"],
                     'name' => 'Date'
                  ],
                  'yAxis' => [
                     'title' => ['text' => 'Average Data']
                  ],
                  'series' => [

                    [ 'type' => 'column',
                      'color' => '#E8B50A',
                      'name' => 'Average Temperature',
                      'data' => $AverageTempMonth ],
                      
                    [ 'type' => 'column',
                      'color' => '#FBC359',
                      'name' => 'Average Humidity',
                      'data' => $AverageHumMonth ],

                  ]
               ]
            ]);

            ?>

          </div>
        </div>
      </div>
      <!-- /.box-body -->
    </div>
  </div>

</div>
<!-- /.row -->




<?php

$fsample = ActiveForm::begin([

"method" => "post",
"action" => Url::toRoute( "site/sounding1chart" ),
"enableClientValidation" => true,
]);

?>

<div class="row">

<!-- Modal -->
<div class="modal fade" id="sample" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="sample">Change Sample Time</h4>
      </div>
      <div class="modal-body">

        <div class="form-group">
          <?= $fsample->field($formsample, 'id')->dropDownList(
               ['sounding1' => 'sounding1', 'sounding2' => 'sounding2']
                ); ?>

        </div>

        <div class="form-group">
         <?= $fsample->field($formsample, 'sampletime')->input("number") ?>
        </div>

        </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <?= Html::submitButton("Save changes", ["class" => "btn btn-primary"]) ?>

      </div>
    </div>
    </div>
  </div>
</div>
</div>


<?php $fsample->end()?>



<?php

$fdevice = ActiveForm::begin([

"method" => "post",
"action" => Url::toRoute( "site/sounding1chart" ),
"enableClientValidation" => true,
]);

?>
<div class="row">

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">New Device</h4>
      </div>
      <div class="modal-body">

        <div class="form-group">

          <?= $fdevice->field($formdevice, 'tipo')->dropDownList(
               ['Counter' => 'Counter']
                ); ?>


        </div>

        <div class="form-group">
          <?= $fdevice->field($formdevice, 'tipo_nom')->dropDownList(
               ['Counter 1' => 'Counter 1', 'Counter 2' => 'Counter 2', 'Counter 3' => 'Counter 3','Counter 4' => 'Counter 4']
                ); ?>

        </div>

        <div class="form-group">
         <?= $fdevice->field($formdevice, "nom")->input("text") ?>
        </div>

        </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <?= Html::submitButton("Save changes", ["class" => "btn btn-primary"]) ?>

      </div>
    </div>
    </div>
  </div>

</div>

<?php $fdevice->end() ?>


<?php

$f = ActiveForm::begin([

"method" => "get",
"action" => Url::toRoute( "site/sounding1chart" ),
"enableClientValidation" => true,
]);

?>

<div class="row">

<!-- Modal -->
<div class="modal fade" id="filter" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"> <i class="fa fa-filter"></i> Filter</h4>
      </div>
      <div class="modal-body">

        <div style="height:120px">
          <?=
           //Usage with model and Active Form (with no default initial value)
           $f->field($formchart, 'FirstDate')->widget(DatePicker::classname(), [
              'options' => ['placeholder' => 'Filter Day ...'],
              'pluginOptions' => [
                  'autoclose'=>true,
                  'format' => 'yyyy-mm-dd'
              ]
            ]);


          ?>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <?= Html::submitButton("Search", ["class" => "btn btn-primary"]) ?>

      </div>
    </div>
    </div>
  </div>
</div>
<?php $f -> end() ?>