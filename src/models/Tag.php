<?php
/**
 * @author Jakhar <https://github.com/jakharbek>
 * @author Nazrullo <https://github.com/nazrullo>
 * @author O`tkir    <https://github.com/utkir24>
 * @team Adigitalteam <https://github.com/adigitalteam>
 * @package Tag of Yii2
 */

namespace adigitalteam\tag\models;

use adigitalteam\tag\slug\behaviors\SlugBehavior;
use Yii;
use yii\db\ActiveRecord;


/**
 * Class Tag
 * @package common\modules\tag\models
 * @property $id integer
 * @property $name string
 * @property $slug string
 * @author Jakhar Nazrullo O'tkir
 */
class Tag extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%tags}}';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'slug' => [
                'class' => SlugBehavior::className(),
                'in_attribute' => 'name',
                'out_attribute' => 'slug',
                'translit' => true
            ],
        ];
    }


    /***
     * This function for create new tag
     * @param $name
     * @return Tag
     */
    public static function create($name){
        $tag = new static();
        $tag->name = $name;
        if(!$tag->save()){
            throw new \RuntimeException('Tag has not saved');
        }
        return $tag;
    }

    /**
     * @param $name
     * @return $this
     */
    public function edit($name){
        $this->name = $name;
        if(!$this->save()){
            throw new \RuntimeException('Tag has not updated');
        }
        return $this;
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['name','slug'], 'string', 'max' => 255],
            [['name','slug'],'unique'],
            ['slug','safe'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'slug' => 'Slug',
        ];
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

}
