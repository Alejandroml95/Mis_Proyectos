<?php
use yii\widgets\Breadcrumbs;
use dmstr\widgets\Alert;
use yii\helpers\Url;
use yii\helpers\Html;

use yii\widgets\ActiveForm;
/* @var $this yii\web\View */

?>
<div class="content-wrapper">
    <section class="content-header">
        <?php if (isset($this->blocks['content-header'])) { ?>
            <h1><?= $this->blocks['content-header'] ?></h1>
        <?php } else { ?>
            <h1>
                <?php
                if ($this->title !== null) {
                    echo \yii\helpers\Html::encode($this->title);
                } else {
                    echo \yii\helpers\Inflector::camel2words(
                        \yii\helpers\Inflector::id2camel($this->context->module->id)
                    );
                    echo ($this->context->module->id !== \Yii::$app->id) ? '<small>Module</small>' : '';
                } ?>
            </h1>
        <?php } ?>

        <?=
        Breadcrumbs::widget(
            [
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]
        ) ?>
    </section>

    <section class="content">
        <?= Alert::widget() ?>
        <?= $content ?>
    </section>
</div>

<footer class="main-footer">
    <div class="pull-right hidden-xs">
        <b>Version</b> 2.0
    </div>
    <strong><a href="http://almsaeedstudio.com">Desarrollador Incocan S.I. 2018 </a>.</strong>
</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
        <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        <!-- Home tab content -->

            <h3 class="control-sidebar-heading">My Devices</h3>
            <ul class='control-sidebar-menu'>

            <?php foreach($dispositivos as $row): ?>

            <?php if( ($row->tipo_nom) == "Counter 1" ){ ?>
                <li>
                    <a href= <?=Url::toRoute( "site/counter1chart" )?> >
                        <i class="menu-icon fa fa-bookmark-o bg-blue"></i>

                        <div class="menu-info">
                            <h4 class="control-sidebar-subheading">Counter 1</h4>
                            <p> <?= $row->nom ?></p>
                        </div>
                    </a>
                </li>
            <?php } ?>
            <?php endforeach ?>

            <?php foreach($dispositivos as $row): ?>
            <?php if( ($row->tipo_nom) == "Counter 2" ){ ?>
            <li>
                <a href=<?=Url::toRoute( "site/counter2chart" )?>>
                    <i class="menu-icon fa fa-bookmark-o bg-blue"></i>

                    <div class="menu-info">
                        <h4 class="control-sidebar-subheading">Counter 2</h4>
                        <p> <?= $row->nom ?></p>
                    </div>
                </a>
            </li>
            <?php } ?>
            <?php endforeach ?>

            <?php foreach($dispositivos as $row): ?>
            <?php if( ($row->tipo_nom) == "Counter 3" ){ ?>
            <li>
                <a href=<?=Url::toRoute( "site/counter3chart" )?>>
                    <i class="menu-icon fa fa-bookmark-o bg-blue"></i>

                    <div class="menu-info">
                        <h4 class="control-sidebar-subheading">Counter 3</h4>
                        <p> <?= $row->nom ?></p>
                    </div>
                </a>
            </li>
            <?php } ?>
            <?php endforeach ?>

            <?php foreach($dispositivos as $row): ?>
            <?php if( ($row->tipo_nom) == "Counter 4" ){ ?>
            <li>
                <a href=<?=Url::toRoute( "site/counter4chart" )?>>
                    <i class="menu-icon fa fa-bookmark-o bg-blue"></i>

                    <div class="menu-info">
                        <h4 class="control-sidebar-subheading">Counter 4</h4>
                        <p> <?= $row->nom ?></p>
                    </div>
                </a>
            </li>
            <?php } ?>
            <?php endforeach ?>

            <?php foreach($dispositivos as $row): ?>

            <?php if( ($row->tipo_nom) == "Sounding 1" ){ ?>
            <li>
                <a href=<?=Url::toRoute( "site/sounding1chart" )?>>
                    <i class="menu-icon fa fa-bookmark-o bg-blue"></i>

                    <div class="menu-info">
                        <h4 class="control-sidebar-subheading">Sounding 1</h4>
                        <p> <?= $row->nom ?></p>
                    </div>
                </a>
            </li>
            <?php } ?>
        <?php endforeach ?>

            <?php foreach($dispositivos as $row): ?>
            <?php if( ($row->tipo_nom) == "Sounding 2" ){ ?>
            <li>
                <a href=<?=Url::toRoute( "site/sounding2chart" )?>>
                    <i class="menu-icon fa fa-bookmark-o bg-blue"></i>

                    <div class="menu-info">
                        <h4 class="control-sidebar-subheading">Sounding 2</h4>
                        <p> <?= $row->nom ?></p>
                    </div>
                </a>
            </li>
            <?php } ?>
            <?php endforeach ?>

            <?php foreach($dispositivos as $row): ?>
            <?php if( ($row->tipo_nom) == "Sounding 3" ){ ?>
            <li>
                <a href=<?=Url::toRoute( "site/sounding3chart" )?>>
                    <i class="menu-icon fa fa-bookmark-o bg-blue"></i>

                    <div class="menu-info">
                        <h4 class="control-sidebar-subheading">Sounding 3</h4>
                        <p> <?= $row->nom ?></p>
                    </div>
                </a>
            </li>
            <?php } ?>
            <?php endforeach ?>

            <?php foreach($dispositivos as $row): ?>
            <?php if( ($row->tipo_nom) == "Sounding 4" ){ ?>
            <li>
                <a href=<?=Url::toRoute( "site/sounding4chart" )?>>
                    <i class="menu-icon fa fa-bookmark-o bg-blue"></i>

                    <div class="menu-info">
                        <h4 class="control-sidebar-subheading">Sounding 4</h4>
                        <p> <?= $row->nom ?></p>
                    </div>
                </a>
            </li>
            <?php } ?>
            <?php endforeach ?>

                <li>
                    <a href='javascript::;'>
                        <div class="menu-info">
                            <!-- Button trigger modal -->
                            <button type="button" class="btn bg-maroon margin" data-toggle="modal" data-target="#myModal">
                              Add Device
                            </button>
                        </div>
                    </a>
                </li>

            </ul>
            <!-- /.control-sidebar-menu -->

            <!-- /.control-sidebar-menu -->

        <!-- /.tab-pane -->

        <!-- Settings tab content -->

        <!-- /.tab-pane -->
    </div>
</aside><!-- /.control-sidebar -->
<!-- Add the sidebar's background. This div must be placed
     immediately after the control sidebar -->
<div class='control-sidebar-bg'></div>
