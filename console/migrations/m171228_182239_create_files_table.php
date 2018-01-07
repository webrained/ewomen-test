<?php
use yii\db\Schema;
use yii\db\Migration;

/**
 * Handles the creation of table `files`.
 */
class m171228_182239_create_files_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('files', [
            'id' => Schema::TYPE_PK,
            'project_id' => Schema::TYPE_INTEGER . "(11)",
            'file_name' => Schema::TYPE_STRING,
            'title' => Schema::TYPE_STRING,
        ]);

        $this->addForeignKey("files_to_projects", "files", "project_id", "projects", "`id`", 'Cascade');
    }


    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('files');
    }
}
