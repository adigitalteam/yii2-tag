<?php
/**
 * @author Jakhar <https://github.com/jakharbek>
 * @author Nazrullo <https://github.com/nazrullo>
 * @author O`tkir    <https://github.com/utkir24>
 * @team Adigitalteam <https://github.com/adigitalteam>
 * @package Tag of Yii2
 */

namespace adigitalteam\tag\behaviors;

use adigitalteam\tag\models\Tag;
use yii\base\Behavior;
use yii\db\ActiveRecord;

/**
 * Class TagBehavior
 * @package adigitalteam\tag\behaviors
 * @property $owner ActiveRecord
 * @property $attribute string
 * @property $relation_name string
 * @author Jakhar Nazrullo O'tkir
 */
class TagBehavior extends Behavior
{
    /**
     * This attribute which is tags are saved or printed
     * @var array
     */
    public $attribute;

    /**
     * This attribute that in model's with relation of tags
     * @var string
     */
    public $relation_name;

    /**
     * @return array
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'saveData',
            ActiveRecord::EVENT_AFTER_UPDATE => 'saveData',
            ActiveRecord::EVENT_AFTER_FIND => 'afterFind'
        ];
    }

    /**
     * Save tags to tags model
     */
    public function saveData($event)
    {
        if(!$this->owner->isNewRecord){
           $this->unlinkData();
        }
        if(is_array($this->owner->{$this->attribute})){
            foreach ($this->owner->{$this->attribute} as $item){
                if($tag = Tag::findOne(['name'=>$item])){
                    $this->owner->link($this->relation_name,$tag);
                }else{
                    $tag = Tag::create($item);
                    $this->owner->link($this->relation_name,$tag);
                }
            }
        }

    }

    /**
     * remove old data
     * @return bool
     */
    protected function unlinkData()
    {
        $relation_data = $this->owner->{$this->relation_name};
        if (count($relation_data) == 0) {
            return false;
        }
        foreach ($relation_data as $data):
            $this->owner->unlink($this->relation_name, $data, true);
        endforeach;
    }

    /**
     * after find model this function will write all data the attribute
     */
    public function afterFind($event)
    {
        $this->owner->{$this->attribute} = $this->owner->{$this->relation_name};
    }

}