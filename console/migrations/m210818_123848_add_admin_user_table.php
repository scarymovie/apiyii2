<?php

use yii\db\Migration;

/**
 * Class m210818_123848_add_admin_user_table
 */
class m210818_123848_add_admin_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user}}','is_admin',
        $this->string(512)->after('username')->defaultValue(1));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210818_123848_add_admin_user_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210818_123848_add_admin_user_table cannot be reverted.\n";

        return false;
    }
    */
}
