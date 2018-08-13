<?php
/**
 * @author Jakhar <https://github.com/jakharbek>
 * @author Nazrullo <https://github.com/nazrullo>
 * @author O`tkir    <https://github.com/utkir24>
 * @team Adigitalteam <https://github.com/adigitalteam>
 * @package Tag of Yii2
 */

namespace adigitalteam\tag\slug\behaviors;

use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\helpers\Inflector;
use adigitalteam\tag\slug\helper\TransliteratorHelper;

/**
 * Class SlugBehavior
 * @package common\modules\tag\slug\behaviors
 * @property $in_attribute string
 * @property  $out_attribute string
 * @property $translit bool
 * @author Jakhar Nazrullo O'tkir
 */
class SlugBehavior extends Behavior
{
    /**
     * @var string
     */
    public $in_attribute = 'title';
    /**
     * @var string
     */
    public $out_attribute = 'slug';
    /**
     * @var bool
     */
    public $translit = true;

    /**
     * @return array
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_VALIDATE => 'getSlug'
        ];
    }

    /**
     * @param $event
     */
    public function getSlug($event)
    {
        if (empty($this->owner->{$this->out_attribute})) {
            $this->owner->{$this->out_attribute} = $this->generateSlug($this->owner->{$this->in_attribute});
        } else {
            $this->owner->{$this->out_attribute} = $this->generateSlug($this->owner->{$this->out_attribute});
        }
    }

    /**
     * @param $slug
     * @return string
     */
    private function generateSlug($slug )
    {
        $slug = $this->slugify( $slug );
        if ( $this->checkUniqueSlug( $slug ) ) {
            return $slug;
        } else {
            for ( $suffix = 2; !$this->checkUniqueSlug( $new_slug = $slug . '-' . $suffix ); $suffix++ ) {}
            return $new_slug;
        }
    }

    /**
     * @param $slug
     * @return string
     */
    private function slugify($slug )
    {
        if ( $this->translit ) {
            return Inflector::slug( TransliteratorHelper::process( $slug ), '-', true );
        } else {
            return $this->slug( $slug, '-', true );
        }
    }

    /**
     * @param $string
     * @param string $replacement
     * @param bool $lowercase
     * @return string
     */
    private function slug($string, $replacement = '-', $lowercase = true )
    {
        $string = preg_replace( '/[^\p{L}\p{Nd}]+/u', $replacement, $string );
        $string = trim( $string, $replacement );
        return $lowercase ? strtolower( $string ) : $string;
    }

    /**
     * @param $slug
     * @return bool
     */
    private function checkUniqueSlug($slug )
    {
        $pk = $this->owner->primaryKey();
        $pk = $pk[0];

        $condition = $this->out_attribute . ' = :out_attribute';
        $params = [ ':out_attribute' => $slug ];
        if ( !$this->owner->isNewRecord ) {
            $condition .= ' and ' . $pk . ' != :pk';
            $params[':pk'] = $this->owner->{$pk};
        }

        return !$this->owner->find()
            ->where( $condition, $params )
            ->one();
    }


}