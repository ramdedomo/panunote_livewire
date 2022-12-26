<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $user_id
 * @property integer $quiz_id
 * @property boolean $quiz_like
 * @property string $created_at
 * @property string $updated_at
 * @property PanunoteQuiz $panunoteQuiz
 * @property PanunoteUser $panunoteUser
 */
class PanunoteQuizLikes extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'panunote_quizlikes';

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'quiz_id', 'quiz_like', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function panunoteQuiz()
    {
        return $this->belongsTo('App\Models\PanunoteQuiz', 'quiz_id', 'quiz_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function panunoteUser()
    {
        return $this->belongsTo('App\Models\PanunoteUser', 'user_id', 'user_id');
    }
}
