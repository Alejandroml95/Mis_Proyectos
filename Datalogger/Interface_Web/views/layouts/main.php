<?php
use yii\helpers\Html;

use app\models\dispositivos;
/* @var $this \yii\web\View */
/* @var $content string */


if (Yii::$app->controller->action->id === 'login') {
/**
 * Do not use this code in your template. Remove it.
 * Instead, use the code  $this->layout = '//main-login'; in your controller.
 */
    echo $this->render(
        'main-login',
        ['content' => $content]
    );
} else {

    if (class_exists('backend\assets\AppAsset')) {
        backend\assets\AppAsset::register($this);
    } else {
        app\assets\AppAsset::register($this);
    }

    dmstr\web\AdminLteAsset::register($this);

    $directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');


    $d = new dispositivos;
    $dispositivos = $d::find() -> all();

    $Counter1 = false;
    $Counter2 = false;
    $Counter3 = false;
    $Counter4 = false;

    $Sounding1 = false;
    $Sounding2 = false;
    $Sounding3 = false;
    $Sounding4 = false;

    foreach($dispositivos as $row){
      if( ($row->tipo_nom) == "Counter 1" ){ $Counter1 = true; break;} else { $Counter1 = false; }
    }
    foreach($dispositivos as $row){
      if( ($row->tipo_nom) == "Counter 2" ){ $Counter2 = true; break;} else { $Counter2 = false; }
    }
    foreach($dispositivos as $row){
      if( ($row->tipo_nom) == "Counter 3" ){ $Counter3 = true; break;} else { $Counter3 = false; }
    }
    foreach($dispositivos as $row){
      if( ($row->tipo_nom) == "Counter 4" ){ $Counter4 = true; break;} else { $Counter4 = false; }
    }
    foreach($dispositivos as $row){
        if( ($row->tipo_nom) == "Sounding 1" ){ $Sounding1 = true; break;} else { $Sounding1 = false; }
      }
      foreach($dispositivos as $row){
        if( ($row->tipo_nom) == "Sounding 2" ){ $Sounding2 = true; break;} else { $Sounding2 = false; }
      }
      foreach($dispositivos as $row){
        if( ($row->tipo_nom) == "Sounding 3" ){ $Sounding3 = true; break;} else { $Sounding3 = false; }
      }
      foreach($dispositivos as $row){
        if( ($row->tipo_nom) == "Sounding 4" ){ $Sounding4 = true; break;} else { $Sounding4 = false; }
      }

    ?>
    <?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body class="hold-transition skin-blue sidebar-mini sidebar-collapse">
    <?php $this->beginBody() ?>
    <div class="wrapper">

        <?= $this->render(
            'header.php',
            ['directoryAsset' => $directoryAsset]
        ) ?>

        <?= $this->render(
            'left.php',
            ['directoryAsset' => $directoryAsset, 'dispositivos' => $dispositivos,
             'Counter1' => $Counter1, 'Counter2' => $Counter2,
             'Counter3' => $Counter3,'Counter4' => $Counter4,
             'Sounding1' => $Sounding1, 'Sounding2' => $Sounding2,
             'Sounding3' => $Sounding3,'Sounding4' => $Sounding4]
        )
        ?>

        <?= $this->render(
            'content.php',
            ['content' => $content, 'directoryAsset' => $directoryAsset,
             'dispositivos' => $dispositivos]
        ) ?>

    </div>

    <?php $this->endBody() ?>
    </body>
    </html>
    <?php $this->endPage() ?>
<?php } ?>
