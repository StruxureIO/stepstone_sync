<?php
/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2021 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\stepstone_sync\tests\codeception\fixtures;

use humhub\modules\post\models\Post;
use yii\test\ActiveFixture;

class ExamFixture extends ActiveFixture
{
    public $modelClass = Post::class; // <-- change me to model

    public $dataFile = '@stepstone_sync/tests/codeception/fixtures/data/exam.php';
    public $depends = [
        //'humhub\modules\stepstone_sync\tests\codeception\fixtures\ExamReadFixture',
    ];
}
