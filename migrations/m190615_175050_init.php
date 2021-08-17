<?php

use yii\db\Migration;

/**
 * Class m190615_175050_init
 */
class m190615_175050_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createTable('{{%store}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->unique(),
            'url' => $this->string()->notNull()->unique(),
            'class_name' => $this->string(), // Класс обработки при необходимости
            'options' => $this->text(),
            'js' => $this->integer()->defaultValue(0), // Флаг JS обработки
            'tag_name' => $this->string(), // Название товара
            'php_name' => $this->text(), // Название товара
            'tag_text' => $this->text(), // Описание товара
            'tag_image' => $this->string(), // Изображение товара
            'tag_price' => $this->string(), // Цена товара
            'tag_action' => $this->string(), // Акция товара
            'tag_availability' => $this->string(), // Наличие товара
            'tag_rating' => $this->string(), // Рейтинг товара
            'tag_reviews' => $this->string(), // Отзывы товара
            'tag_position' => $this->string(), // Ссылки в категории
        ], $tableOptions);

        $this->createTable('{{%link}}', [
            'id' => $this->primaryKey(),
            'store_id' => $this->integer()->notNull(),
            'name' => $this->string(32)->notNull(), // название ссылки
            'link' => $this->string()->notNull()->unique(), // ссылка на товар
            'link_category' => $this->string(), // ссылка на категорию
        ], $tableOptions);

        $this->createTable('{{%product}}', [
            'id' => $this->primaryKey(),
            'linkId' => $this->integer()->notNull(),
            'name' => $this->string(), // Название товара
            'text' => $this->text(), // Описание товара
            'image' => $this->string(), // Изображение товара
            'price' => $this->string(), // Цена товара
            'action' => $this->string(), // Акция товара
            'availability' => $this->string(), // Наличие товара
            'rating' => $this->string(), // Рейтинг товара
            'reviews' => $this->text(), // Отзывы товара
            'position' => $this->string(), // Позиция в категории
            'createdAt' => $this->integer()->notNull(),
            'updatedAt' => $this->integer()->notNull(),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%product}}');
        $this->dropTable('{{%link}}');
        $this->dropTable('{{%store}}');
        $this->dropTable('{{%user}}');
    }
}
