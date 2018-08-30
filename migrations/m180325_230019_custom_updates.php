<?php

use yii\db\Migration;

/**
 * Class m180325_230019_user_firstname_lastname
 */
class m180325_230019_custom_updates extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn("user", "firstname", $this->string(255)->notNull()->after("id"));
        $this->addColumn("user", "lastname", $this->string(255)->notNull()->after("firstname"));
        $this->addColumn("user", "failed_logins", $this->integer()->notNull()->unsigned());

        if (Yii::$app->db->schema->getTableSchema('user')->getColumn("username")){
            $this->dropColumn("user", "username");
        }

        if (Yii::$app->db->schema->getTableSchema('profile')) {
            $this->dropTable("profile");
        }

        /* ROLES */
        $auth = Yii::$app->getAuthManager();

        $superadmin = $auth->createRole('superadmin');
        $auth->add($superadmin);

        $admin = $auth->createRole('admin');
        $auth->add($admin);

        $auth->addChild($superadmin, $admin);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn("user", "firstname");
        $this->dropColumn("user", "lastname");
        $auth = Yii::$app->getAuthManager()->removeAll();
    }

}
