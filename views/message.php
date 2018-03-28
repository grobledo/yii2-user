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
 * @var yii\web\View $this
 * @var grobledo\user\Module $module
 */

$this->title = $title;
?>

<?= $this->render('/_alert', ['module' => $module]);
