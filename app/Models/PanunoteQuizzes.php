<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $quiz_id
 * @property integer $note_id
 * @property integer $user_id
 * @property boolean $quiz_sharing
 * @property string $quiz_title
 * @property string $updated_at
 * @property string $created_at
 * @property string $quiz_tags
 * @property PanunoteGamificationRoom[] $panunoteGamificationRooms
 * @property PanunoteQuestion[] $panunoteQuestions
 * @property PanunoteQuizlike[] $panunoteQuizlikes
 * @property PanunoteQuiztake[] $panunoteQuiztakes
 * @property PanunoteQuizvisit[] $panunoteQuizvisits
 * @property PanunoteNote $panunoteNote
 * @property PanunoteUser $panunoteUser
 */
class PanunoteQuizzes extends Model
{
    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'quiz_id';

    /**
     * @var array
     */
    protected $fillable = ['note_id', 'user_id', 'quiz_sharing', 'quiz_title', 'updated_at', 'created_at', 'quiz_tags'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function panunoteGamificationRooms()
    {
        return $this->hasMany('App\Models\PanunoteGamificationRoom', 'quiz_id', 'quiz_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function panunoteQuestions()
    {
        return $this->hasMany('App\Models\PanunoteQuestion', 'quiz_id', 'quiz_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function panunoteQuizlikes()
    {
        return $this->hasMany('App\Models\PanunoteQuizlike', 'quiz_id', 'quiz_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function panunoteQuiztakes()
    {
        return $this->hasMany('App\Models\PanunoteQuiztake', 'quiz_id', 'quiz_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function panunoteQuizvisits()
    {
        return $this->hasMany('App\Models\PanunoteQuizvisit', 'quiz_id', 'quiz_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function panunoteNote()
    {
        return $this->belongsTo('App\Models\PanunoteNote', 'note_id', 'note_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function panunoteUser()
    {
        return $this->belongsTo('App\Models\PanunoteUser', 'user_id', 'user_id');
    }

    public static function searchall($search)
    {
        return empty($search) ? static::query()
            : static::query()->where('user_id', session('USER_ID'))
            ->where('quiz_title', 'like', '%'.$search.'%')
                ->orWhere(function ($query) use ($search) {
                    $query->where('user_id', 'like', '%'.$search.'%')
                        ->where('quiz_id', 'like', '%'.$search.'%')
                        ->where('quiz_tags', 'like', '%'.$search.'%')
                        ->where('note_id', 'like', '%'.$search.'%');
                });
    }

    public static function search($search)
    {
        return empty($search) ? static::query()
            : static::query()->where('panunote_quizzes.quiz_sharing', 1)
                ->where('panunote_quizzes.quiz_title', 'like', '%'.$search.'%')
                ->orWhere(function ($query) use ($search) {
                    $query->where('panunote_quizzes.user_id', 'like', '%'.$search.'%')
                        ->where('panunote_quizzes.quiz_id', 'like', '%'.$search.'%')
                        ->where('panunote_quizzes.quiz_tags', 'like', '%'.$search.'%')
                        ->where('panunote_quizzes.note_id', 'like', '%'.$search.'%');
                });
    }
}
