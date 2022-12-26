<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $question_id
 * @property integer $quiz_id
 * @property string $question_text
 * @property boolean $question_type
 * @property integer $question_difficulty
 */
class PanunoteQuestions extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'panunote_questions';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'question_id';

    /**
     * @var array
     */
    protected $fillable = ['updated_at', 'created_at', 'question_id', 'quiz_id', 'question_text', 'question_type', 'question_difficulty'];

}
