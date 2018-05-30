<?php

/*
 * This file is part of the grobledo project.
 *
 * (c) grobledo project <http://github.com/grobledo>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use grobledo\user\helpers\RoleUtils;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;


/**
 * @var \yii\web\View $this
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var \grobledo\user\models\UserSearch $searchModel
 */

$this->title = Yii::t('user', 'Manage users');
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('/admin/_menu') ?>

<?php Pjax::begin() ?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'layout' => "{items}\n{pager}",
    'columns' => [
        [
            'attribute' => 'id',
            'headerOptions' => ['style' => 'width:90px;'], # 90px is sufficient for 5-digit user ids
        ],
        'firstname',
        'lastname',
        'email',
        [
            'attribute' => 'role',
            'filterType' => GridView::FILTER_SELECT2,
            'filter' => RoleUtils::getRoles(),
            'filterWidgetOptions' => [
                'pluginOptions' => ['allowClear' => true],
            ],
            'filterInputOptions' => ['placeholder' => ''],
            'headerOptions' => ['style' => 'min-width:140px'],
        ],
        [
            'attribute' => 'created_at',
            'format' => 'date'
        ],

        [
            'attribute' => 'last_login_at',
            'value' => function ($model) {
                if (!$model->last_login_at || $model->last_login_at == 0) {
                    return Yii::t('user', 'Never');
                } else if (extension_loaded('intl')) {
                    return Yii::t('user', '{0, date, MMMM dd, YYYY HH:mm}', [$model->last_login_at]);
                } else {
                    return date('Y-m-d G:i:s', $model->last_login_at);
                }
            },
        ],
        [
            'header' => Yii::t('user', 'Confirmation'),
            'value' => function ($model) {
                if ($model->isConfirmed) {
                    return '<div class="text-center">
                                <span class="text-success">' . Yii::t('user', 'Confirmed') . '</span>
                            </div>';
                } else {
                    return Html::a(Yii::t('user', 'Confirm'), ['confirm', 'id' => $model->id], [
                        'class' => 'btn btn-xs btn-success btn-block',
                        'data-method' => 'post',
                        'data-confirm' => Yii::t('user', 'Are you sure you want to confirm this user?'),
                    ]);
                }
            },
            'format' => 'raw',
            'visible' => Yii::$app->getModule('user')->enableConfirmation,
        ],
        [
            'header' => Yii::t('user', 'Block status'),
            'value' => function ($model) {
                if ($model->isBlocked) {
                    return Html::a(Yii::t('user', 'Blocked'), null, [
                        'class' => 'btn btn-xs btn-danger btn-block',
                    ]);
                } else {
                    return Html::a(Yii::t('user', 'Active'), null, [
                        'class' => 'btn btn-xs btn-success btn-block',
                    ]);
                }
            },
            'format' => 'raw',
        ],
        [
            'format' => 'raw',
            'value' => function ($model) {
                if (\Yii::$app->user->identity->isAdmin && $model->id != Yii::$app->user->id && Yii::$app->getModule('user')->enableImpersonateUser) {
                    $switch = '<li>' . Html::a(Yii::t('user', 'Become this user'), ['/user/admin/switch', 'id' => $model->id], [
                        'title' => Yii::t('user', 'Become this user'),
                        'data-confirm' => Yii::t('user', 'Are you sure you want to switch to this user for the rest of this Session?'),
                        'data-method' => 'POST',
                    ]) . '</li>';
                }
                if (\Yii::$app->user->identity->isAdmin && !$model->isAdmin && Yii::$app->getModule('user')->enableSendNewPassword) {
                    $resend_password = '<li><a data-method="POST" data-confirm="' . Yii::t('user', 'Are you sure?') . '" href="' . Url::to(['resend-password', 'id' => $model->id]) . '">
                    ' . Yii::t('user', 'Generate and send new password to user') . '</a></li>';
                }

                $delete = '<li>' . Html::a(Yii::t('user', 'Delete'), ['/user/admin/delete', 'id' => $model->id], [
                        'title' => Yii::t('user', 'Delete'),
                        'data-confirm' => Yii::t('user', 'Are you sure you want to delete this user?'),
                        'data-method' => 'POST',
                    ]) . '</li>';

                if ($model->isBlocked) {
                    $block =  '<li>'.Html::a(Yii::t('user', 'Unblock'), ['block', 'id' => $model->id], [
                        'data-method' => 'post',
                        'data-confirm' => Yii::t('user', 'Are you sure you want to unblock this user?'),
                    ]).'</li>';
                } else {
                    $block = '<li>'.Html::a(Yii::t('user', 'Block'), ['block', 'id' => $model->id], [
                        'data-method' => 'post',
                        'data-confirm' => Yii::t('user', 'Are you sure you want to block this user?'),
                    ]).'</li>';
                }

                $update = '<li>' . Html::a(Yii::t('user', 'Update'), ['/user/admin/update', 'id' => $model->id]) . '</li>';

                return '<div class="btn-group">
                      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                        ' . Yii::t("user", "Actions") . ' <span class="caret"></span>
                      </button>
                      <ul class="dropdown-menu" role="menu">
                        '.$update.'
                        '.(isset($switch) ? $switch : '').'
                        '.(isset($resend_password) ? $resend_password : '').'
                        '.$block.'
                        <li class="divider"></li>
                        '.$delete.'
                      </ul>
                    </div>';
            }
        ],
    ],
]); ?>

<?php Pjax::end() ?>
