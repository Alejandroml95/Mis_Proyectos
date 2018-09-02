<?php
use yii\helpers\Html;

use miloschuman\highcharts\Highcharts;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */

$this->title = '';
?>
<br>
<div class="site-index">

</div>

<script>

  $('#myModal').on('shown.bs.modal', function () {
    $('#myInput').focus()
  })

</script>

<?php if ($nCounter != 0  ) {  ?>

<div class="row">

  <?php foreach($dispositivos as $row): ?>

    <?php if( ($row->tipo) == "Counter" ){ ?>

      <?php if( ($row->tipo_nom) == "Counter 1" || ($row->tipo_nom) == "Counter 2"){ ?>

        <?php if ($nCounter <= 2  ) { ?>
          <div class="col-lg-6 col-xs-6">
          <?php } else { ?>
          <div class="col-lg-3 col-xs-6">
        <?php } ?>

      <?php } else {?>
        <div class="col-lg-3 col-xs-6">
      <?php } ?>

      <?php if( ($row->tipo_nom) == "Counter 1" ){ ?> 
        <div class="small-box bg-teal-gradient">
      <?php } elseif(($row->tipo_nom) == "Counter 2") {?>
        <div class="small-box bg-green-gradient">
      <?php } elseif(($row->tipo_nom) == "Counter 3") {?>
        <div class="small-box bg-yellow-gradient">
      <?php } elseif(($row->tipo_nom) == "Counter 4") {?>
        <div class="small-box bg-red-gradient">
      <?php } ?>

          <div class="inner">
            <h3><?= $row->tipo_nom ?></h3>
            <p><?= $row->nom ?></p>
          </div>
          <div class="icon">
            <i class="fa fa-bookmark-o"></i>
          </div>
          <?php if( ($row->tipo_nom) == "Counter 1" ){ ?> 
            <?= Html::a('More info', ['counter1chart'], ['class'=>'small-box-footer'] ) ?>
          <?php } elseif(($row->tipo_nom) == "Counter 2") {?>
            <?= Html::a('More info', ['counter2chart'], ['class'=>'small-box-footer'] ) ?>
          <?php } elseif(($row->tipo_nom) == "Counter 3") {?>
            <?= Html::a('More info', ['counter3chart'], ['class'=>'small-box-footer'] ) ?>
          <?php } elseif(($row->tipo_nom) == "Counter 4") {?>
            <?= Html::a('More info', ['counter4chart'], ['class'=>'small-box-footer'] ) ?>
          <?php } ?>
          
        </div>
      </div>
    <?php } ?>

  <?php endforeach ?>

</div>

<div class="row">

  <div class="col-md-3">
    <div class="nav-tabs-custom">
      <!-- Tabs within a box -->
      <ul class="nav nav-tabs pull-right">
        <li class="pull-left header"><i class="fa fa-pie-chart"></i> <?= $month ?> - Openning Time <i class="fa fa-hourglass-2"></i></li>
      </ul>
      <div class="tab-content no-padding">
        <!-- Morris chart - Sales -->
        <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: 384px;">

          <?php

          //Monto un array con los datos que quiero introducir en la gráfica
          //y después compruebo si los dispositivos estan en este array
          //En caso de que no el valor que se muestra en la gráfica será 0
          $nomdis = array();
          foreach($dispositivos as $row){ array_push($nomdis, $row->tipo_nom);}
          if ( !(in_array("Counter 1", $nomdis)) ) { $Counter1MonthOT = 0; $Counter1MonthNT = 0;}
          if ( !(in_array("Counter 2", $nomdis)) ) { $Counter2MonthOT = 0; $Counter2MonthNT = 0;}
          if ( !(in_array("Counter 3", $nomdis)) ) { $Counter3MonthOT = 0; $Counter3MonthNT = 0;}
          if ( !(in_array("Counter 4", $nomdis)) ) { $Counter4MonthOT = 0; $Counter4MonthNT = 0;}
                                        
          echo Highcharts::widget([
          
               'options' => [
                  'title' => ['text' => ' '],
                  'plotOptions' => [
                      'pie' => [
                          'borderColor' => '#FFFFFF',
                          'colors'=> [ '#27BBFB', '#0E8C1F','#E8B50A','#F53E3E'],
                          'size' => 200,
                          'dataLabels' => [
                              'enabled' => false
                          ]
                      ]
                  ],
                  'series' => [
                     [ // new opening bracket
                      'type' => 'pie',
                      'name' => 'Opening Time',
                      'data' => [
                                ['Counter 1', $Counter1MonthOT],
                                ['Counter 2', $Counter2MonthOT],
                                ['Counter 3', $Counter3MonthOT],
                                ['Counter 4', $Counter4MonthOT]
                        ],
                      ]
                    ]
                  ]
                ]);
                      
          ?>

        </div>
      </div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="nav-tabs-custom">
      <!-- Tabs within a box -->
      <ul class="nav nav-tabs pull-right">
        <li class="pull-left header"><i class="fa fa-pie-chart"></i> <?= $month ?> - Number of Time <i class="fa fa-plus-circle"></i></li>
      </ul>
      <div class="tab-content no-padding">
        <!-- Morris chart - Sales -->
        <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: 384px;">

          <?php
          echo Highcharts::widget([

               'options' => [
                  'title' => ['text' => ' '],
                  'plotOptions' => [
                      'pie' => [
                          'cursor' => 'pointer',
                          'borderColor' => '#FFFFFF',
                          'colors'=> [ '#27BBFB', '#0E8C1F','#E8B50A','#F53E3E'],
                          'size' => 200,
                          'dataLabels' => [
                              'enabled' => false
                          ]
                      ]
                  ],
                  'series' => [
                     [ // new opening bracket
                      'type' => 'pie',
                      'name' => 'Number of Openning',
                      'data' => [
                          ['Counter 1', $Counter1MonthNT],
                          ['Counter 2', $Counter2MonthNT],
                          ['Counter 3', $Counter3MonthNT],
                          ['Counter 4', $Counter4MonthNT]
                                ],
                      ]

                    ]
                  ]
                ]);

          ?>

        </div>
      </div>
    </div>
  </div>

  <div class="col-xs-6">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title">Today - Data</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body table-responsive ">
        <table class="table table-hover">
          <tr>
            <th>ID</th>
            <th>OPENNING TIME <i class="fa fa-hourglass-2"></i></th>
            <th>NUMBER OF OPENNING <i class="fa fa-plus-circle"></i></th>
          </tr>

          <?php $i = 0; ?>
          <?php foreach($dispositivos as $row): ?>
            <?php if ( ($row->tipo) == "Counter"  ) { ?>
              <tr> 
                  <td><?= $row->tipo_nom ?></td>
                  <td><span class="label label-primary"><?=$ArraySumOT[$i]?> seconds</td>
                  <td><span class="label label-success"><?=$ArraySumNT[$i]?> time</td>
              </tr>
            <?php $i++; }?>
          <?php endforeach ?>
          <tr>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          
        </table>
      </div>
      <!-- /.box-body -->
    </div>
  </div>

</div>

<?php } ?>


<?php if ($nSounding != 0  ) {  ?>

<div class="row">

  <?php foreach($dispositivos as $row): ?>

    <?php if( ($row->tipo) == "Sounding" ){ ?>

      <?php if( ($row->tipo_nom) == "Sounding 1" || ($row->tipo_nom) == "Sounding 2"){ ?>

        <?php if ($nSounding <= 2  ) { ?>
          <div class="col-lg-6 col-xs-6">
          <?php } else { ?>
          <div class="col-lg-3 col-xs-6">
        <?php } ?>

      <?php } else {?>
        <div class="col-lg-3 col-xs-6">
      <?php } ?>

      <?php if( ($row->tipo_nom) == "Sounding 1" ){ ?> 
        <div class="small-box bg-teal-gradient">
      <?php } elseif(($row->tipo_nom) == "Sounding 2") {?>
        <div class="small-box bg-green-gradient">
      <?php } elseif(($row->tipo_nom) == "Sounding 3") {?>
        <div class="small-box bg-yellow-gradient">
      <?php } elseif(($row->tipo_nom) == "Sounding 4") {?>
        <div class="small-box bg-red-gradient">
      <?php } ?>

          <div class="inner">
            <h3><?= $row->tipo_nom ?></h3>
            <p><?= $row->nom ?></p>
          </div>
          <div class="icon">
            <i class="fa fa-bookmark-o"></i>
          </div>
          <?php if( ($row->tipo_nom) == "Sounding 1" ){ ?> 
            <?= Html::a('More info', ['sounding1chart'], ['class'=>'small-box-footer'] ) ?>
          <?php } elseif(($row->tipo_nom) == "Sounding 2") {?>
            <?= Html::a('More info', ['sounding2chart'], ['class'=>'small-box-footer'] ) ?>
          <?php } elseif(($row->tipo_nom) == "Sounding 3") {?>
            <?= Html::a('More info', ['sounding3chart'], ['class'=>'small-box-footer'] ) ?>
          <?php } elseif(($row->tipo_nom) == "Sounding 4") {?>
            <?= Html::a('More info', ['sounding4chart'], ['class'=>'small-box-footer'] ) ?>
          <?php } ?>
          
        </div>
      </div>
    <?php } ?>

  <?php endforeach ?>

</div>

<div class="row">

<div class="col-xs-6">
  <div class="box">
    <div class="box-header">
      <h3 class="box-title">Current Data</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body table-responsive ">
      <table class="table table-hover">
        <tr>
          <th>ID</th>
          <th>Temperature</th>
          <th>Humedity</th>
        </tr>

        <?php $i = 0; ?>
        <?php foreach($dispositivos as $row): ?>
          <?php if ( ($row->tipo) == "Sounding"  ) { ?>
            <tr> 
                <td><?= $row->tipo_nom ?></td>
                <td><span class="label label-primary"><?=$ArrayCurrentData[$i] -> Temperatura?> ºC</td>
                <td><span class="label label-success"><?=$ArrayCurrentData[$i] -> Humedad?> %</td>
            </tr>
          <?php $i++; }?>
        <?php endforeach ?>
        <tr>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        
      </table>
    </div>
    <!-- /.box-body -->
  </div>
</div>

<!-- /.box -->

<div class="col-md-3">
  <div class="nav-tabs-custom">
    <!-- Tabs within a box -->
    <ul class="nav nav-tabs pull-right">
      <li class="pull-left header"><i class="fa fa-pie-chart"></i> <?= $month ?> - Average Temperature </li>
    </ul>
    <div class="tab-content no-padding">
      <!-- Morris chart - Sales -->
      <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: 384px;">

        <?php
        echo Highcharts::widget([

             'options' => [
                'title' => ['text' => ' '],
                'plotOptions' => [
                    'pie' => [
                        'cursor' => 'pointer',
                        'borderColor' => '#FFFFFF',
                        'colors'=> [ '#27BBFB', '#0E8C1F','#E8B50A','#F53E3E'],
                        'size' => 200,
                        'dataLabels' => [
                            'enabled' => false
                        ]
                    ]
                ],
                'series' => [
                   [ // new opening bracket
                    'type' => 'pie',
                    'name' => 'Average Temperature',
                    'data' => [
                        ['Sounding 1', $AverageTempMonthS1],
                        ['Sounding 2', $AverageTempMonthS2],
                        ['Sounding 3', $AverageTempMonthS3],
                        ['Sounding 4', $AverageTempMonthS4]
                              ],
                    ]

                  ]
                ]
              ]);

        ?>

      </div>
    </div>
  </div>
</div>

<div class="col-md-3">
  <div class="nav-tabs-custom">
    <!-- Tabs within a box -->
    <ul class="nav nav-tabs pull-right">
      <li class="pull-left header"><i class="fa fa-pie-chart"></i> <?= $month ?> - Average Humidity </li>
    </ul>
    <div class="tab-content no-padding">
      <!-- Morris chart - Sales -->
      <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: 384px;">

        <?php
        echo Highcharts::widget([

             'options' => [
                'title' => ['text' => ' '],
                'plotOptions' => [
                    'pie' => [
                        'cursor' => 'pointer',
                        'borderColor' => '#FFFFFF',
                        'colors'=> [ '#27BBFB', '#0E8C1F','#E8B50A','#F53E3E'],
                        'size' => 200,
                        'dataLabels' => [
                            'enabled' => false
                        ]
                    ]
                ],
                'series' => [
                   [ // new opening bracket
                    'type' => 'pie',
                    'name' => 'Average Temperature',
                    'data' => [
                        ['Sounding 1', $AverageHumMonthS1],
                        ['Sounding 2', $AverageHumMonthS2],
                        ['Sounding 3', $AverageHumMonthS3],
                        ['Sounding 4', $AverageHumMonthS4]
                              ],
                    ]

                  ]
                ]
              ]);

        ?>

      </div>
    </div>
  </div>
</div>

</div>

<?php } ?>


<?php

$fdevice = ActiveForm::begin([

"method" => "post",
"action" => Url::toRoute( "site/index" ),
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
        <h4 class="modal-title" id="myModalLabel"> <i class="fa fa-plus"></i> New Device</h4>
      </div>
      <div class="modal-body">

        <div class="form-group">

          <?= $fdevice->field($formdevice, 'tipo')->dropDownList(
               ['Counter' => 'Counter', 'Sounding' => 'Sounding']
                ); ?>


        </div>

        <div class="form-group">
          <?= $fdevice->field($formdevice, 'tipo_nom')->dropDownList(
               ['1' => '1', '2' => '2', '3' => '3','4' => '4']
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


