
<?php

  use yii\helpers\Url;
  use yii\helpers\Html;
  use yii\widgets\ActiveForm;

  use yii\grid\GridView;

  use yii\data\Paginatation;
  use yii\widgets\LinkPager;
  use kartik\date\DatePicker;
  use kartik\export\ExportMenu;

 ?>

<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/boxed-bg.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p>Carrier</p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>


        <?=

        dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                  
                    ['label' => 'My Devices', 'options' => ['class' => 'header']],
                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                    ['label' => 'Counters',
                      'icon' => 'cloud',
                      'active' => true,
                      'url' => '#',
                      'items' => [
                            ['label' => 'Counter 1', 'icon' => 'cube', 'url' => ['counterdata1'],
                              'visible' => $Counter1,
                              'icon' => 'bookmark',
                              'url' => 'counterdata1',
                              'items' => [
                                  ['label' => 'Data', 'icon' => 'database', 'url' => ['counterdata1'] ],
                                  ['label' => 'Chart', 'icon' => 'bar-chart', 'url' => ['counter1chart'] ],
                                  ['label' => 'Files', 'icon' => 'cloud-download', 'url' => ['counter1download'] ],
                                ],
                              ],
                              ['label' => 'Counter 2', 'icon' => 'cube', 'url' => ['counterdata2'],
                                'visible' => $Counter2,
                                'icon' => 'bookmark',
                                'url' => '#',
                                'items' => [
                                    ['label' => 'Data', 'icon' => 'database', 'url' => ['counterdata2'] ],
                                    ['label' => 'Chart', 'icon' => 'bar-chart', 'url' => ['counter2chart'] ],
                                    ['label' => 'Files', 'icon' => 'cloud-download', 'url' => ['counter2download'] ],
                                  ],
                                ],
                                ['label' => 'Counter 3', 'icon' => 'cube', 'url' => ['counterdata3'],
                                  'visible' => $Counter3,
                                  'icon' => 'bookmark',
                                  'url' => '#',
                                  'items' => [
                                      ['label' => 'Data', 'icon' => 'database', 'url' => ['counterdata3'] ],
                                      ['label' => 'Chart', 'icon' => 'bar-chart', 'url' => ['counter3chart'] ],
                                      ['label' => 'Files', 'icon' => 'cloud-download', 'url' => ['counter3download'] ],
                                    ],
                                  ],
                                  ['label' => 'Counter 4', 'icon' => 'cube', 'url' => ['counterdata4'],
                                    'visible' => $Counter4,
                                    'icon' => 'bookmark',
                                    'url' => '#',
                                    'items' => [
                                        ['label' => 'Data', 'icon' => 'database', 'url' => ['counterdata4'] ],
                                        ['label' => 'Chart', 'icon' => 'bar-chart', 'url' => ['counter4chart'] ],
                                        ['label' => 'Files', 'icon' => 'cloud-download', 'url' => ['counter4download'] ],
                                      ],
                                    ],
                        ],
                      ],

                      ['label' => 'Sounding',
                      'icon' => 'eyedropper',
                      'active' => true,
                      'url' => '#',
                      'items' => [
                            ['label' => 'Sounding 1', 'icon' => 'cube', 'url' => ['sounding1chart'],
                              'visible' =>  $Sounding1,//$Counter1,
                              'icon' => 'eyedropper',
                              'url' => 'counterdata1',
                              'items' => [
                                  ['label' => 'Data', 'icon' => 'database', 'url' => ['soundingdata1'] ],
                                  ['label' => 'Chart', 'icon' => 'bar-chart', 'url' => ['sounding1chart'] ],
                                  ['label' => 'Files', 'icon' => 'cloud-download', 'url' => ['sounding1download'] ],
                                ],
                              ],
                              ['label' => 'Sounding 2', 'icon' => 'cube', 'url' => ['data'],
                                'visible' => $Sounding2,//$Counter2,
                                'icon' => 'eyedropper',
                                'url' => '#',
                                'items' => [
                                    ['label' => 'Data', 'icon' => 'database', 'url' => ['soundingdata2'] ],
                                    ['label' => 'Chart', 'icon' => 'bar-chart', 'url' => ['sounding2chart'] ],
                                    ['label' => 'Files', 'icon' => 'cloud-download', 'url' => ['sounding2download'] ],
                                  ],
                                ],
                                ['label' => 'Sounding 3', 'icon' => 'cube', 'url' => ['data'],
                                  'visible' => $Sounding3,//$Counter3,
                                  'icon' => 'eyedropper',
                                  'url' => '#',
                                  'items' => [
                                      ['label' => 'Data', 'icon' => 'database', 'url' => ['soundingdata3'] ],
                                      ['label' => 'Chart', 'icon' => 'bar-chart', 'url' => ['sounding3chart'] ],
                                      ['label' => 'Files', 'icon' => 'cloud-download', 'url' => ['sounding3download'] ],
                                    ],
                                  ],
                                  ['label' => 'Sounding 4', 'icon' => 'cube', 'url' => ['data'],
                                    'visible' => $Sounding4,//$Counter4,
                                    'icon' => 'eyedropper',
                                    'url' => '#',
                                    'items' => [
                                        ['label' => 'Data', 'icon' => 'database', 'url' => ['soundingdata4'] ],
                                        ['label' => 'Chart', 'icon' => 'bar-chart', 'url' => ['sounding4chart'] ],
                                        ['label' => 'Files', 'icon' => 'cloud-download', 'url' => ['sounding4download'] ],
                                      ],
                                    ],
                        ],
                      ],


                      ['label' => 'Setting', 'options' => ['class' => 'header']],
                      ['label' => 'My Devices', 'icon' => 'gears', 'url' => ['configdispositivo']],
                    ],
                  ]
          ) ?>

    </section>

</aside>
