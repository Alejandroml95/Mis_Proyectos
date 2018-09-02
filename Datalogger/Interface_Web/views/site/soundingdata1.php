<?php

  use yii\helpers\Url;
  use yii\helpers\Html;
  use yii\widgets\ActiveForm;

  use yii\grid\GridView;

  use yii\data\Paginatation;
  use yii\widgets\LinkPager;
  use kartik\date\DatePicker;
  use kartik\export\ExportMenu;

 $this->title = 'Sounding 1 ';
 $this->params['breadcrumbs'][] = $this->title;
 ?>

 <div class="site-data">

 </div>


<br>

<div class="row">

<div class="col-md-3">
<div class="info-box bg-yellow-gradient">
        <!-- Apply any bg-* class to to the icon to color it -->
        <span class="info-box-icon"><i class="fa fa-calendar"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Filter Day</span>
          <span class="info-box-number"><?= $FilterDayFD ?> - <?= $FilterDayED ?></span>
        </div><!-- /.info-box-content -->
      </div><!-- /.info-box -->

</div>

<div class="col-md-2 pull-right">
  <a href='javascript::;'>
    <div class="menu-info">
    <!-- Button trigger modal -->
      <button type="button" class="btn btn-block bg-gray" data-toggle="modal" data-target="#filter">
        Filter                                        
      </button>
    </div>
  </a>
</div>


  <div class="col-md-12">
    <div class="box box-success">
      <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-database"></i> Data</h3>
        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
          </button>
          <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>

      </div>

      <div class="box-body">
        <div class="chart">

          <div style="height:100%">

            <table class="table table-striped table-bordered" >

              <thead>
                <tr>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Temperature</th>
                    <th>Humedity</th>
                </tr>
            </thead>
            <tbody>

              <?php foreach ($model as $row): ?>

              <tr>
                <td><?= $row -> Fecha ?> </td>
                <td> <?= $row -> Horario ?> </td>
                <td> <?= $row -> Temperatura ?> </td>
                <td> <?= $row -> Humedad ?> </td>

              </tr>

              <?php endforeach ?>

            </tbody>

            <tfoot>
                <tr>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Temperature</th>
                    <th>Humedity</th>
                </tr>
            </tfoot>

          </table>

          <?= LinkPager::widget([

            "pagination" => $pages,

          ]);
          ?>

          </div>
        </div>
      </div>
    </div>
  </div>

</div>


<?php

$fdevice = ActiveForm::begin([

"method" => "post",
"action" => Url::toRoute( "site/counter1chart" ),
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



<?php

$f = ActiveForm::begin([

"method" => "get",
"action" => Url::toRoute( "site/counterdata1" ),
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
        <h4 class="modal-title" id="myModalLabel">Filter</h4>
      </div>
      <div class="modal-body">

        <div style="height:120px">
          <?=
            //Usage with model and Active Form (with no default initial value)
            $f->field($form, 'FirstDate')->widget(DatePicker::classname(), [
              'options' => ['placeholder' => 'Enter birth date ...'],
              'pluginOptions' => [
                  'autoclose'=>true,
                  'format' => 'yyyy-mm-dd'
              ]
            ]);


          ?>

          <?=
           //Usage with model and Active Form (with no default initial value)
           $f->field($form, 'EndDate')->widget(DatePicker::classname(), [
              'options' => ['placeholder' => 'Enter birth date ...'],
              'pluginOptions' => [
                  'autoclose'=>true,
                  'format' => 'yyyy-mm-dd'
              ]
            ]);

          ?>
        </div>
        <br>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <?= Html::submitButton("Search", ["class" => "btn btn-primary"]) ?>

      </div>
    </div>
    </div>
  </div>
</div>
<?php $f -> end() ?>