<?php

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\DataProviderInterface */

$this->title = 'Matched providers';

use app\models\Provider;
use yii\grid\GridView;
use yii\helpers\Html;
?>
<div class="container">

    <div style="float: right;"><button class="custom-call green">Custom call</button></div>
    <h1><?= Html::encode($this->title) ?></h1>

    <?php
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'layout' => "{items}\n{pager}",
            'columns' => [
                [
                    'label' => 'Type',
                    'format' => 'html',
                    'value' => function ($data) {
                        $type = $data['contracted'] == Provider::TYPE_CONTRACTED ? '<img src="/img/type-contracted.png">' : '<img src="/img/type-non-contracted.png">';
                        return $type;
                    },
                ],
                [
                    'label' => false,
                    'format' => 'html',
                    'value' => function ($data) {
                        $subject = $data['contracted'] == Provider::SUBJECT_PERSON ? '<img src="/img/person.png">' : '<img src="/img/company.png">';
                        return $subject;
                    },
                ],
                [
                    'label' => 'Name',
                    'format' => 'html',
                    'attribute' => 'name',
                    'value' => function ($data) {
                        $content = '<strong>' . $data['name'] . '</strong>';
                        $content .= '<div class="email">' . $data['email'] . '</div>';
                        $content .= '<div class="phone">' . $data['phone'] . '</div>';
                        return $content ;
                    },
                ],
                [
                    'label' => 'Email',
                    'attribute' => 'email',
                    'headerOptions' => [
                        'class' => 'email'
                    ],
                    'contentOptions' => [
                        'class' => 'email'
                    ]
                ],
                [
                    'label' => 'Phone',
                    'attribute' => 'phone',
                    'headerOptions' => [
                        'class' => 'phone'
                    ],
                    'contentOptions' => [
                        'class' => 'phone'
                    ]
                ],
                'id',
                [
                    'label' => 'Status',
                    'format' => 'html',
                    'attribute' => 'status',
                    'value' => function ($data) {

                        switch($data['status']) {
                            case Provider::STATUS_TALKED:
                                $description = 'Talked to the client';
                                $status = '<span class="icon"><img src="/img/status-talked.png" title="' . $description . '"></span> <span class="status">' . $description . '</span>';
                                break;
                            case Provider::STATUS_ASSESSMENT:
                                $description = 'Assessment sheduled';
                                $status = '<span class="icon"><img src="/img/status-assessment.png" title="' . $description . '"></span> <span class="status">' . $description . '</span>';
                                break;
                            case Provider::STATUS_CONTRACT:
                                $description = 'Contract signed';
                                $status = '<span class="icon"><img src="/img/status-contract.png" title="' . $description . '"></span> <span class="status">' . $description . '</span>';
                                break;
                            case Provider::STATUS_CANCEL:
                                $description = 'Cancel the client';
                                $status = '<span class="icon"><img src="/img/status-cancel.png" title="' . $description . '"></span> <span class="status">' . $description . '</span>';
                                break;
                            default:
                                $description = 'Contacting';
                                $status = '<span class="icon"><img src="/img/status-contacting.png" title="' . $description . '"></span> <span class="status">' . $description . '</span>';
                                break;
                        }

                        return $status;
                    },
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{chat} {call}',
                    'buttons' => [
                        'chat' => function ($url, $model, $key) {
                            return '<button class="chat cyan">Chat</button>';
                        },
                        'call' => function ($url, $model, $key) {
                            return '<button class="call green">Call</button>';
                        },
                    ]
                ],
            ],
        ]);
    ?>

    <blockquote>Note: there are no server-side storage for data, so providers are being generated randomly every time you make an URL-request.</blockquote>
</div>
