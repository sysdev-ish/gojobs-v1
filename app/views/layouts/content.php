<?php

use yii\widgets\Breadcrumbs;
use dmstr\widgets\Alert;

?>
<div class="content-wrapper">

    <style>
        .m-0 {
            margin: 0 !important;
        }

        .m-1 {
            margin: .25rem !important;
        }

        .m-2 {
            margin: .5rem !important;
        }

        .m-3 {
            margin: 1rem !important;
        }

        .m-4 {
            margin: 1.5rem !important;
        }

        .m-5 {
            margin: 3rem !important;
        }

        .mt-0 {
            margin-top: 0 !important;
        }

        .mr-0 {
            margin-right: 0 !important;
        }

        .mb-0 {
            margin-bottom: 0 !important;
        }

        .ml-0 {
            margin-left: 0 !important;
        }

        .mx-0 {
            margin-left: 0 !important;
            margin-right: 0 !important;
        }

        .my-0 {
            margin-top: 0 !important;
            margin-bottom: 0 !important;
        }

        .mt-1 {
            margin-top: .25rem !important;
        }

        .mr-1 {
            margin-right: .25rem !important;
        }

        .mb-1 {
            margin-bottom: .25rem !important;
        }

        .ml-1 {
            margin-left: .25rem !important;
        }

        .mx-1 {
            margin-left: .25rem !important;
            margin-right: .25rem !important;
        }

        .my-1 {
            margin-top: .25rem !important;
            margin-bottom: .25rem !important;
        }

        .mt-2 {
            margin-top: .5rem !important;
        }

        .mr-2 {
            margin-right: .5rem !important;
        }

        .mb-2 {
            margin-bottom: .5rem !important;
        }

        .ml-2 {
            margin-left: .5rem !important;
        }

        .mx-2 {
            margin-right: .5rem !important;
            margin-left: .5rem !important;
        }

        .my-2 {
            margin-top: .5rem !important;
            margin-bottom: .5rem !important;
        }

        .mt-3 {
            margin-top: 1rem !important;
        }

        .mr-3 {
            margin-right: 1rem !important;
        }

        .mb-3 {
            margin-bottom: 1rem !important;
        }

        .ml-3 {
            margin-left: 1rem !important;
        }

        .mx-3 {
            margin-right: 1rem !important;
            margin-left: 1rem !important;
        }

        .my-3 {
            margin-bottom: 1rem !important;
            margin-top: 1rem !important;
        }

        .mt-4 {
            margin-top: 1.5rem !important;
        }

        .mr-4 {
            margin-right: 1.5rem !important;
        }

        .mb-4 {
            margin-bottom: 1.5rem !important;
        }

        .ml-4 {
            margin-left: 1.5rem !important;
        }

        .mx-4 {
            margin-right: 1.5rem !important;
            margin-left: 1.5rem !important;
        }

        .my-4 {
            margin-top: 1.5rem !important;
            margin-bottom: 1.5rem !important;
        }

        .mt-5 {
            margin-top: 3rem !important;
        }

        .mr-5 {
            margin-right: 3rem !important;
        }

        .mb-5 {
            margin-bottom: 3rem !important;
        }

        .ml-5 {
            margin-left: 3rem !important;
        }

        .mx-5 {
            margin-right: 3rem !important;
            margin-left: 3rem !important;
        }

        .my-5 {
            margin-top: 3rem !important;
            margin-bottom: 3rem !important;
        }

        .mt-auto {
            margin-top: auto !important;
        }

        .mr-auto {
            margin-right: auto !important;
        }

        .mb-auto {
            margin-bottom: auto !important;
        }

        .ml-auto {
            margin-left: auto !important;
        }

        .mx-auto {
            margin-right: auto !important;
            margin-left: auto !important;
        }

        .my-auto {
            margin-bottom: auto !important;
            margin-top: auto !important;
        }

        .p-0 {
            padding: 0 !important;
        }

        .p-1 {
            padding: .25rem !important;
        }

        .p-2 {
            padding: .5rem !important;
        }

        .p-3 {
            padding: 1rem !important;
        }

        .p-4 {
            padding: 1.5rem !important;
        }

        .p-5 {
            padding: 3rem !important;
        }

        .pt-0 {
            padding-top: 0 !important;
        }

        .pr-0 {
            padding-right: 0 !important;
        }

        .pb-0 {
            padding-bottom: 0 !important;
        }

        .pl-0 {
            padding-left: 0 !important;
        }

        .px-0 {
            padding-left: 0 !important;
            padding-right: 0 !important;
        }

        .py-0 {
            padding-top: 0 !important;
            padding-bottom: 0 !important;
        }

        .pt-1 {
            padding-top: .25rem !important;
        }

        .pr-1 {
            padding-right: .25rem !important;
        }

        .pb-1 {
            padding-bottom: .25rem !important;
        }

        .pl-1 {
            padding-left: .25rem !important;
        }

        .px-1 {
            padding-left: .25rem !important;
            padding-right: .25rem !important;
        }

        .py-1 {
            padding-top: .25rem !important;
            padding-bottom: .25rem !important;
        }

        .pt-2 {
            padding-top: .5rem !important;
        }

        .pr-2 {
            padding-right: .5rem !important;
        }

        .pb-2 {
            padding-bottom: .5rem !important;
        }

        .pl-2 {
            padding-left: .5rem !important;
        }

        .px-2 {
            padding-right: .5rem !important;
            padding-left: .5rem !important;
        }

        .py-2 {
            padding-top: .5rem !important;
            padding-bottom: .5rem !important;
        }

        .pt-3 {
            padding-top: 1rem !important;
        }

        .pr-3 {
            padding-right: 1rem !important;
        }

        .pb-3 {
            padding-bottom: 1rem !important;
        }

        .pl-3 {
            padding-left: 1rem !important;
        }

        .py-3 {
            padding-bottom: 1rem !important;
            padding-top: 1rem !important;
        }

        .px-3 {
            padding-right: 1rem !important;
            padding-left: 1rem !important;
        }

        .pt-4 {
            padding-top: 1.5rem !important;
        }

        .pr-4 {
            padding-right: 1.5rem !important;
        }

        .pb-4 {
            padding-bottom: 1.5rem !important;
        }

        .pl-4 {
            padding-left: 1.5rem !important;
        }

        .px-4 {
            padding-right: 1.5rem !important;
            padding-left: 1.5rem !important;
        }

        .py-4 {
            padding-top: 1.5rem !important;
            padding-bottom: 1.5rem !important;
        }

        .pt-5 {
            padding-top: 3rem !important;
        }

        .pr-5 {
            padding-right: 3rem !important;
        }

        .pb-5 {
            padding-bottom: 3rem !important;
        }

        .pl-5 {
            padding-left: 3rem !important;
        }

        .px-5 {
            padding-right: 3rem !important;
            padding-left: 3rem !important;
        }

        .py-5 {
            padding-top: 3rem !important;
            padding-bottom: 3rem !important;
        }
    </style>
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
        <b>Version</b> 1.1
    </div>
    <strong>Copyright &copy; 2018 - <script>
            document.write(new Date().getFullYear())
        </script> <a href="http://ish.co.id">Infomedia Solusi Humanika</a>.</strong> All rights reserved.
</footer>