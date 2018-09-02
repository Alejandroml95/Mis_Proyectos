<?php

  use yii\helpers\Url;
  use yii\helpers\Html;
  use yii\widgets\ActiveForm;

  use yii\grid\GridView;

  use yii\data\Paginatation;
  use yii\widgets\LinkPager;
  use kartik\date\DatePicker;
  use kartik\export\ExportMenu;

 $this->title = 'Setting Devices';
 $this->params['breadcrumbs'][] = $this->title;
 ?>

 <div class="site-configdispositivo">

 </div>


 <?php

   $f = ActiveForm::begin([

   "method" => "post",
   "enableClientValidation" => true,
   ]);

 ?>


<?php

  $f = ActiveForm::begin([
  "method" => "post",
  "enableClientValidation" => true,
  ]);

?>

  <br><br>

<section class="content">

  <?php if( $nCounter != 0 ){ ?>

  <div class="row">
    <div class="col-xs-6">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Counters</h3>

        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive">
          <table class="table table-hover">
            <tr>
              <th>ID</th>
              <th>NAME</th>
              <th></th>
            </tr>

            <?php foreach($dispositivos as $row): ?>
              <?php if( ($row->tipo) == "Counter" ){ ?>
            <tr> 
                <td><?= $row->tipo_nom ?></td>
                <td><?= $row->nom ?></td>

                <td>
                  <?= Html::beginForm(Url::toRoute("site/delete"), "POST") ?>
                    <input type="hidden" name="tipo_nom" value="<?= $row->tipo_nom ?>">
                    <button type="submit" class="btn btn-primary">Delete</button>
                  <?= Html::endForm() ?>
                </td>
            </tr>
              <?php } ?>
            <?php endforeach ?>

          </table>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
    <?php } ?>
 
    <?php if( $nSounding != 0 ){ ?>

    <div class="col-xs-6">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Sounding Lines</h3>

        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive ">
          <table class="table table-hover">
            <tr>
              <th>ID</th>
              <th>NAME</th>
              <th></th>
            </tr>

          
            <?php foreach($dispositivos as $row): ?>
              <?php if( ($row->tipo) == "Sounding" ){ ?>
            <tr> 
                <td><?= $row->tipo_nom ?></td>
                <td><?= $row->nom ?></td>

                <td>
                  <?= Html::beginForm(Url::toRoute("site/delete"), "POST") ?>
                    <input type="hidden" name="tipo_nom" value="<?= $row->tipo_nom ?>">
                    <button type="submit" class="btn btn-primary">Delete</button>
                  <?= Html::endForm() ?>
                </td>
            </tr>
              <?php } ?>
            <?php endforeach ?>
          
          </table>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
  </div>

  <?php } ?>

</section>

<?php

$fdevice = ActiveForm::begin([

"method" => "post",
"action" => Url::toRoute( "site/configdispositivo" ),
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



