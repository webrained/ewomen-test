<?php
use yii\db\Schema;
use yii\db\Migration;

/**
 * Handles the creation of table `technologies`.
 */
class m171228_161203_create_technologies_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('technologies', [
            'id' => Schema::TYPE_PK,
            'technology_name' => Schema::TYPE_STRING,
        ]);

        $technologies = ['PHP','.NET','Javascript','Java','C++','Python','ReactJS','LESS/SASS','HTML','RoR','Lua','Other'];

        for ($i = 0; $i < count($technologies); $i++){
            $this->insert('technologies',array(
                'technology_name'=>$technologies[$i],
            ));
        }

    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('technologies');
    }
}
