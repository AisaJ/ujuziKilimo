<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%crop}}`.
 */
class m190720_113733_create_crop_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%tbl_crop}}', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'Description' => $this->text()->notNull(),
            'updated_at' => $this->timestamp(),
            'created_at' => $this->timestamp(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%tbl_crop}}');
    }
}
