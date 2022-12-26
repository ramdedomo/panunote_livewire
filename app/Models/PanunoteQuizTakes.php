<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $user_id
 * @property integer $quiz_id
 * @property string $created_at
 * @property string $updated_at
 * @property integer $user_average
 * @property PanunoteUser $panunoteUser
 * @property PanunoteQuiz $panunoteQuiz
 */
class PanunoteQuizTakes extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'panunote_quiztakes';

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'quiz_id', 'created_at', 'updated_at', 'user_average'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function panunoteUser()
    {
        return $this->belongsTo('App\Models\PanunoteUser', 'user_id', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function panunoteQuiz()
    {
        return $this->belongsTo('App\Models\PanunoteQuiz', 'quiz_id', 'quiz_id');
    }
}
