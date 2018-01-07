<?php
use yii\db\Schema;
use yii\db\Migration;

/**
 * Handles the creation of table `projects`.
 */
class m171228_182142_create_projects_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('projects', [
            'id' => Schema::TYPE_PK,
            'project_name' => Schema::TYPE_STRING,
            'project_owner_id' => Schema::TYPE_INTEGER . "(11)",
            'client_name' => Schema::TYPE_STRING,
            'project_description' => Schema::TYPE_STRING,
            'title' => Schema::TYPE_STRING,
            'project_type_id' => Schema::TYPE_INTEGER . "(11)",
            'project_technology_id' => Schema::TYPE_INTEGER . "(11)",
        ]);

        $this->addForeignKey("fk_projects_project_type", "projects", "project_type_id", "project_type", "`id`", 'Cascade');
        $this->addForeignKey("fk_projects_technologies", "projects", "project_technology_id", "technologies", "`id`", 'Cascade');
        $this->addForeignKey("fk_projects_user", "projects", "project_owner_id", "user", "`id`", 'Cascade');



    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('projects');
    }
}
