<?php

/* @var $this yii\web\View */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Sounding 1';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-sounding1download">

</div>

<br>

<section class="content">
  <div class="col-md-12">
    <div class="box box-danger">
      <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-database"></i> Files</h3>
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
                  <th>Id Sounding</th>  
                  <th>Month</th>
                  <th>Year</th>
                  <th>Downoad</th>
                </tr>
            </thead>
            <tbody>
              <?php for ($i = 1; $i <= count($Id) ; $i++) { ?>

                <tr>
                  <td> Sounding <?= $Id[$i - 1] ?> </td>
                  <td><?= $Month[$i - 1] ?> </td>
                  <td> <?= $Year[$i - 1] ?> </td>
                  <td> <?= Html::a("Here",Url::base().'/archivos/'.$NameFiles[$i - 1]) ?> </td>
                </tr>

              <?php } ?>
            </tbody>

            <tfoot>
              <tr>
                <th>Id Sounding</th>  
                <th>Month</th>
                <th>Year</th>
                <th>Downoad</th>
              </tr>
            </tfoot>

          </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


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