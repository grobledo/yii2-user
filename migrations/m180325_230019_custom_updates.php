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
        $this->addColumn("user","firstname",$this->string(255)->notNull()->after("id"));
        $this->addColumn("user","lastname",$this->string(255)->notNull()->after("firstname"));
        $this->dropColumn("user", "username");
        $this->dropTable("profile");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn("user","firstname");
        $this->dropColumn("user","lastname");
    }

}
