<?php

namespace ovidiupop\address\migrations;

use yii\db\Migration;

/**
 * Handles the creation of table `{{%address}}`.
 */
class m240103_165225_create_address_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%address}}', [
            'id' => $this->primaryKey(),
            'country' => $this->string(),
            'region' => $this->string(),
            'city' => $this->string(),
            'postal_code' => $this->string(),
            'street' => $this->string(),
            'house_number' => $this->string(),
            'apartment_number' => $this->string(),
            'address_type' => $this->string(),
            'additional_info' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%address}}');
    }
}