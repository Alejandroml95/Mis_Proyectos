<?php

  use yii\helpers\Url;
  use yii\helpers\Html;
  use yii\widgets\ActiveForm;

  use yii\grid\GridView;

  use yii\data\Paginatation;
  use yii\widgets\LinkPager;
  use kartik\date\DatePicker;
  use kartik\export\ExportMenu;

 $this->title = 'Counter 2 ';
 $this->params['breadcrumbs'][] = $this->title;
 ?>

 <div class="site-data">

 </div>


<br>

<?php

  $f = ActiveForm::begin([

  "method" => "get",
  "action" => Url::toRoute( "site/data" ),
  "enableClientValidation" => true,
  ]);

?>

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

<div class="col-md-9">
  <div class="box box-solid box-primary collapsed-box">
    <div class="box-header with-border">
      <h3 class="box-title"><i class="fa fa-filter"></i> Filter</h3>
      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
        </button>
        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
      </div>

    </div>

    <div class="box-body">
      <div class="chart">

        <div style="height:190px">

          <?=
           //Usage with model and Active Form (with no default initial value)
           $f->field($form, 'FirstDate')->widget(DatePicker::classname(), [
              'options' => ['placeholder' => 'Filter Day ...'],
              'pluginOptions' => [
                  'autoclose'=>true,
                  'format' => 'yyyy-mm-dd'
              ]
            ]);


          ?>

          <?=
           //Usage with model and Active Form (with no default initial value)
           $f->field($form, 'EndDate')->widget(DatePicker::classname(), [
              'options' => ['placeholder' => 'Filter Day ...'],
              'pluginOptions' => [
                  'autoclose'=>true,
                  'format' => 'yyyy-mm-dd'
              ]
            ]);

          ?>


          <?= Html::submitButton("Search", ["class" => "btn btn-primary"]) ?>
          <?php $f->end() ?>

        </div>
      </div>
    </div>
  </div>
</div>

  <br><br>

<section class="content">
  <div class="col-md-12">
    <div class="box box-solid box-success">
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
                    <th>Opening Date</th>
                    <th>Opening Hours</th>
                    <th>Clousing Date</th>
                    <th>Clousing Hours</th>
                    <th>Opening Time (s)</th>
                </tr>
            </thead>
            <tbody>

              <?php foreach ($model as $row): ?>

              <tr>
                <td><?= $row -> FechaApertura ?> </td>
                <td> <?= $row -> HorarioApertura ?> </td>
                <td> <?= $row -> FechaCierre ?> </td>
                <td> <?= $row -> HorarioCierre ?> </td>
                <td> <?= $row -> TiempoApertura ?> </td>

              </tr>

              <?php endforeach ?>

            </tbody>

            <tfoot>
                <tr>
                  <th>Opening Date</th>
                  <th>Opening Hours</th>
                  <th>Clousing Date</th>
                  <th>Clousing Hours</th>
                  <th>Opening Time (s)</th>
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
</section>



<?php

$fdevice = ActiveForm::begin([

"method" => "post",
"action" => Url::toRoute( "site/counterdata2" ),
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


