<?php

namespace backend\modules\users\controllers;

use Yii;

use common\modules\users\models\ar\UserVisitLog;
use common\modules\users\models\search\UserVisitLogSearch;

/**
 * Class UserVisitLogController
 * @package common\modules\users\controllers
 */
class UserVisitLogController extends \common\modules\users\components\Controller
{
    /**
     * @var UserVisitLog
     */
    public $modelClass = 'common\modules\users\models\ar\UserVisitLog';

    /**
     * @var UserVisitLogSearch
     */
    public $modelSearchClass = 'common\modules\users\models\search\UserVisitLogSearch';

    /**
     * @var 
     */
    public $enableOnlyActions = ['index', 'view'];
}
