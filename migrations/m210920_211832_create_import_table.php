<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%my_input}}`.
 */
class m210920_211832_create_import_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%import}}', [
            'id' => $this->primaryKey(),
            'data' => $this->text()->Null(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%my_import}}');
    }
}
