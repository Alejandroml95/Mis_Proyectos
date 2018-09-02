<?php

  use yii\helpers\Url;
  use yii\helpers\Html;
  use yii\widgets\ActiveForm;

  use yii\grid\GridView;

  use yii\data\Paginatation;
  use yii\widgets\LinkPager;
  use kartik\date\DatePicker;
  use kartik\export\ExportMenu;

 $this->title = 'Setting';
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


<br>

<?php

  $f = ActiveForm::begin([
  "method" => "post",
  "enableClientValidation" => true,
  ]);

?>

  <br><br>

<section class="content">
  <div class="col-md-6">
    <div class="box box-solid box-success">
      <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-database"></i> New Counter</h3>
        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
          </button>
          <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>

      </div>

      <div class="box-body">
        <div class="chart">

          <div style="height: 300px">

            <div class="form-group">
              <?= $f->field($form, 'tipo')->dropDownList(
  			           ['Counter' => 'Counter']
  			            ); ?>
            </div>

            <div class="form-group">
              <?= $f->field($form, 'tipo_nom')->dropDownList(
  			           ['Counter 1' => 'Counter 1', 'Counter 2' => 'Counter 2', 'Counter 3' => 'Counter 3','Counter 4' => 'Counter 4']
  			            ); ?>
            </div>

            <div class="form-group">
             <?= $f->field($form, "nom")->input("text") ?>
            </div>

            <?= Html::submitButton("Crear", ["class" => "btn btn-primary"]) ?>

            <?php $f->end() ?>


          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-6">
    <div class="box box-solid box-success">
      <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-database"></i> Lista de Dispositivos</h3>
        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
          </button>
          <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>

      </div>

      <div class="box-body">
        <div class="chart">

          <div style="height: 300px">

            <table class="table table-bordered">
                <tr>
                    <th>Tipo</th>
                    <th>Identificador</th>
                    <th>Nombre</th>
                    <th></th>
                    <th></th>
                </tr>
                <?php foreach($dispositivos as $row): ?>
                <tr>
                    <td><?= $row->tipo ?></td>
                    <td><?= $row->tipo_nom ?></td>
                    <td><?= $row->nom ?></td>

                    <td>
                      <?= Html::beginForm(Url::toRoute("site/delete"), "POST") ?>
                        <input type="hidden" name="tipo_nom" value="<?= $row->tipo_nom ?>">
                        <button type="submit" class="btn btn-primary">Eliminar</button>
                      <?= Html::endForm() ?>
                    </td>
                </tr>
                <?php endforeach ?>
            </table>

          </div>
        </div>
      </div>
    </div>
  </div>

</section>
