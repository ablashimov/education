<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int|null $exam_answer_id
 * @property int|null $question_choice_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnswerChoice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnswerChoice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnswerChoice query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnswerChoice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnswerChoice whereExamAnswerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnswerChoice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnswerChoice whereQuestionChoiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnswerChoice whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AnswerChoice extends Model
{
    protected $fillable = [
        'question_choice_id',
    ];
}
