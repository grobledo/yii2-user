<?php

/*
 * This file is part of the grobledo project.
 *
 * (c) grobledo project <http://github.com/grobledo>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

/**
 * @var yii\widgets\ActiveForm $form
 * @var grobledo\user\models\User $user
 */
?>

<?= $form->field($user, 'firstname')->textInput(['maxlength' => 255]) ?>
<?= $form->field($user, 'lastname')->textInput(['maxlength' => 255]) ?>
<?= $form->field($user, 'email')->textInput(['maxlength' => 255]) ?>
<?= $form->field($user, 'password')->passwordInput() ?>
