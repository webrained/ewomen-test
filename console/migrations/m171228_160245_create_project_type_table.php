<?php
use yii\db\Schema;
use yii\db\Migration;

/**
 * Handles the creation of table `project_type`.
 */
class m171228_160245_create_project_type_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('project_type', [
            'id' => Schema::TYPE_PK,
            'type_name' => Schema::TYPE_STRING,
        ]);

        $type_name = ['Fixed Price','Time-and-Materials','Hourly Payment', 'By Contract', 'Other'];

        for ($i = 0; $i < count($type_name); $i++){
            $this->insert('project_type',array(
                'type_name'=>$type_name[$i],
            ));
        }
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('project_type');
    }
}
