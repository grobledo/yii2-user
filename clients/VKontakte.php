<?php

/*
 * This file is part of the grobledo project
 *
 * (c) grobledo project <http://github.com/grobledo>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace grobledo\user\clients;

use Yii;
use yii\authclient\clients\VKontakte as BaseVKontakte;

/**
 * @author Dmitry Erofeev <dmeroff@gmail.com>
 */
class VKontakte extends BaseVKontakte implements ClientInterface
{
    /** @inheritdoc */
    public $scope = 'email';

    /** @inheritdoc */
    public function getEmail()
    {
        return $this->getAccessToken()->getParam('email');
    }

    /** @inheritdoc */
    public function getUsername()
    {
        return isset($this->getUserAttributes()['screen_name'])
            ? $this->getUserAttributes()['screen_name']
            : null;
    }

    /** @inheritdoc */
    protected function defaultTitle()
    {
        return Yii::t('user', 'VKontakte');
    }
}
