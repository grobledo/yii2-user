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
use grobledo\user\widgets\UserMenu;

/**
 * @var grobledo\user\models\User $user
 */

$user = Yii::$app->user->identity;
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">
            <?= $user->email ?>
        </h3>
    </div>
    <div class="panel-body">
        <?= UserMenu::widget() ?>
    </div>
</div>
