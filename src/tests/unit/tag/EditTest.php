<?php
/**
 * @author Jakhar <https://github.com/jakharbek>
 * @author Nazrullo <https://github.com/nazrullo>
 * @author O`tkir    <https://github.com/utkir24>
 * @team Adigitalteam <https://github.com/adigitalteam>
 * @package Tag of Yii2
 */

namespace adigitalteam\tag\tests\unit\tag;

use adigitalteam\tag\models\Tag;
use Yii;
use yii\test\ActiveFixture;

/**
 * Tag Edit test
 */
class EditTest extends \Codeception\Test\Unit
{
    /**
     * @var \common\tests\UnitTester
     */
    protected $tester;


    /**
     * @return array
     */
    public function _fixtures()
    {
        return [
            'user' => [
                'class' => ActiveFixture::className(),
                'modelClass' => Tag::className(),
                'dataFile' => codecept_data_dir() . 'tag.php'
            ]
        ];
    }

    public function testTagCreate()
    {
        $tag = Tag::create(
            $name = 'New'
        );

        $tag = $tag->edit(
            $name = 'Updated'
        );

        $this->assertEquals($name, $tag->name);
    }


}
