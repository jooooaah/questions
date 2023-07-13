<?php
/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\questions\helpers;

use humhub\modules\content\components\ContentContainerActiveRecord;
use humhub\modules\questions\models\Question;
use humhub\modules\questions\models\QuestionAnswer;
use yii\helpers\Url as BaseUrl;

class Url extends BaseUrl
{
    const ROUTE_QUESTION_CREATE = '/questions/question/create';
    const ROUTE_QUESTION_CREATE_FORM = '/questions/question/create-form';
    const ROUTE_QUESTION_EDIT = '/questions/question/edit';

    const ROUTE_ANSWER_EDIT = '/questions/answer/edit';
    const ROUTE_ANSWER_VOTE = '/questions/answer/vote';
    const ROUTE_ANSWER_SELECT_BEST = '/questions/answer/select-best';

    private static function create($route, $params = [], ContentContainerActiveRecord $container = null)
    {
        if ($container) {
            return $container->createUrl($route, $params);
        } else {
            $params[0] = $route;
            return static::to($params);
        }
    }

    public static function toViewQuestion(Question $question): string
    {
        return $question->content->container->createUrl(null, ['contentId' => $question->content->id]);
    }

    public static function toEditQuestion(Question $question): string
    {
        return static::create(static::ROUTE_QUESTION_EDIT, ['id' => $question->id], $question->content->container);
    }

    public static function toCreateAnswer(Question $question): string
    {
        return self::toViewQuestion($question) . '#create-answer-form';
    }

    public static function toViewAnswers(Question $question): string
    {
        return self::toViewQuestion($question) . '#answers';
    }

    public static function toEditAnswer(QuestionAnswer $answer): string
    {
        return static::create(static::ROUTE_ANSWER_EDIT, ['qid' => $answer->question->id, 'id' => $answer->id], $answer->question->content->container);
    }

    public static function toVoteUpAnswer(QuestionAnswer $answer): string
    {
        return static::create(static::ROUTE_ANSWER_VOTE, ['id' => $answer->id, 'vote' => 'up'], $answer->question->content->container);
    }

    public static function toVoteDownAnswer(QuestionAnswer $answer): string
    {
        return static::create(static::ROUTE_ANSWER_VOTE, ['id' => $answer->id, 'vote' => 'down'], $answer->question->content->container);
    }

    public static function toSelectBestAnswer(QuestionAnswer $answer): string
    {
        return static::create(static::ROUTE_ANSWER_SELECT_BEST, ['id' => $answer->id], $answer->question->content->container);
    }
}
