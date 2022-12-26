<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $answer_id
 * @property integer $question_id
 * @property string $answer_text
 * @property boolean $is_right
 * @property integer $answer_type
 * @property boolean $is_disabled
 * @property PanunoteQuestion $panunoteQuestion
 */
class PanunoteAnswers extends Model
{
    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'answer_id';

    /**
     * @var array
     */
    protected $fillable = ['answer_id', 'question_id', 'answer_text', 'is_right', 'answer_type', 'is_disabled'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function panunoteQuestion()
    {
        return $this->belongsTo('App\Models\PanunoteQuestion', 'question_id', 'question_id');
    }

    public $timestamps = false;
}
