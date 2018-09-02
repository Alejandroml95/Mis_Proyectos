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
//use kartik\widgets\SideNav;
use kartik\sidenav\SideNav;

$this->title = 'Counter 2';
$this->params['breadcrumbs'][] = $this->title;

?>


<?php

  $f = ActiveForm::begin([

  "method" => "get",
  "action" => Url::toRoute( "site/counter2chart" ),
  "enableClientValidation" => true,
  ]);

?>
<br><br>

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
<div class="info-box bg-red-gradient">
        <!-- Apply any bg-* class to to the icon to color it -->
        <span class="info-box-icon"><i class="fa fa-hourglass-2"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Openning Time</span>
          <span class="info-box-number"><?= $SumOpenningTime?> seconds</span>
        </div><!-- /.info-box-content -->
      </div><!-- /.info-box -->

</div>
<div class="col-md-3">
  <div class="info-box bg-green-gradient">
    <!-- Apply any bg-* class to to the icon to color it -->
    <span class="info-box-icon"><i class="fa fa-plus-square-o"></i></span>
    <div class="info-box-content">
      <span class="info-box-text">Number of Opennig</span>
      <span class="info-box-number"><?= $NumberOfOpenning?> time</span>
    </div><!-- /.info-box-content -->
  </div><!-- /.info-box -->
</div>

<div class="col-md-3">
  <div class="box box-solid box-primary collapsed-box">
    <div class="box-header with-border">
      <h3 class="box-title"><i class="fa fa-filter"></i>  Filter</h3>
      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
        </button>
        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
      </div>

    </div>

    <div class="box-body">
      <div class="chart">

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
          <?= Html::submitButton("Search", ["class" => "btn btn-primary"]) ?>
          <?php $f -> end() ?>
        </div>
      </div>
    </div>
  </div>
</div>

<section class="content">

  <div class="row">

    <div class="col-md-12">
      <!-- AREA CHART -->
      <div class="box box-solid box-info">
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
                       'categories' => $tableTime,
                       'title' => ['text' => 'TIME']
                    ],
                    'yAxis' => [
                       'title' => ['text' => 'OPENING TIME']
                    ],
                    'series' => [
                       [ 'type' => 'column',
                         'color' => '#1AC4D5',
                         'name' => 'Opening Time',
                         'data' => $tableDay, '#0F4EEA',

                        ],

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
    
    <!-- /.col (LEFT) -->
    <div class="col-md-6">
      <!-- LINE CHART -->
      <div class="box box-solid box-success">
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
                       'categories' => $Day,
                       'name' => 'TIME'
                    ],
                    'yAxis' => [
                       'title' => ['text' => 'OPENING TIME']
                    ],
                    'series' => [

                       [ 'type' => 'column',
                         'color' => '#46A457',
                         'name' => 'Opening Time',
                         'data' => $arrayOpenningTime ],

                       [ 'type' => 'column',
                         'color' => '#7EF794',
                         'name' => 'Number of Opening',
                         'data' => $arrayNumberOpenning ]

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


    <div class="col-md-6">
      <!-- LINE CHART -->
      <div class="box box-solid box-warning">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-bar-chart"></i> Months Chart</h3>

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
                       'categories' => ["January", "Febrary","March","April","May","June","July","August", "September", "October", "November", "Dicember"]
                    ],
                    'yAxis' => [
                       'title' => ['text' => 'Opening Time']
                    ],
                    'series' => [
                       [ 'type' => 'column',
                         'color' => '#E8B50A',
                         'name' => 'Opening Time',
                         'data' => $arrayOpenningTimeMonth ],

                       [ 'type' => 'column',
                         'color' => '#FBC359',
                         'name' => 'Number of Opening',
                         'data' =>$arrayNumberOpenningMonth ]
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
  </div>
  <!-- /.row -->

</section>

<?php

  $fdevice = ActiveForm::begin([

  "method" => "post",
  "action" => Url::toRoute( "site/graficas" ),
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
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <?= Html::submitButton("Save changes", ["class" => "btn btn-primary"]) ?>

        </div>
      </div>
      </div>
    </div>

</div>

<?php $fdevice->end() ?>
