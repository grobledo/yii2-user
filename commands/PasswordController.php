<?php

/*
 * This file is part of the grobledo project.
 *
 * (c) grobledo project <http://github.com/grobledo/>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace grobledo\user\commands;

use grobledo\user\Finder;
use Yii;
use yii\console\Controller;
use yii\helpers\Console;

/**
 * Updates user's password.
 *
 * @property \grobledo\user\Module $module
 *
 * @author Dmitry Erofeev <dmeroff@gmail.com>
 */
class PasswordController extends Controller
{
    /** @var Finder */
    protected $finder;

    /**
     * @param string           $id
     * @param \yii\base\Module $module
     * @param Finder           $finder
     * @param array            $config
     */
    public function __construct($id, $module, Finder $finder, $config = [])
    {
        $this->finder = $finder;
        parent::__construct($id, $module, $config);
    }

    /**
     * Updates user's password to given.
     *
     * @param string $search   Email or username
     * @param string $password New password
     */
    public function actionIndex($search, $password)
    {
        $user = $this->finder->findUserByEmail($search);
        if ($user === null) {
            $this->stdout(Yii::t('user', 'User is not found') . "\n", Console::FG_RED);
        } else {
            if ($user->resetPassword($password)) {
                $this->stdout(Yii::t('user', 'Password has been changed') . "\n", Console::FG_GREEN);
            } else {
                $this->stdout(Yii::t('user', 'Error occurred while changing password') . "\n", Console::FG_RED);
            }
        }
    }
}
