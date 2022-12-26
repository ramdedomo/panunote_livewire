<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $user_id
 * @property string $email
 * @property string $user_fname
 * @property string $user_lname
 * @property string $username
 * @property string $password
 * @property PanunoteNote[] $panunoteNotes
 * @property PanunoteNote[] $panunoteNotes
 * @property PanunoteQuiz[] $panunoteQuizzes
 * @property PanunoteQuiz[] $panunoteQuizzes
 * @property PanunoteSubject[] $panunoteSubjects
 * @property PanunoteSubject[] $panunoteSubjects
 */
class PanunoteUsers extends Model
{
    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'user_id';

    /**
     * @var array
     */


    protected $fillable = ['user_id', 'email', 'user_fname', 'user_lname', 'username', 'password', 'user_photo'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function panunoteNotes()
    {
        return $this->belongsToMany('App\Models\PanunoteNote', 'panunote_notelikes', 'user_id', 'note_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function panunoteQuizzes()
    {
        return $this->belongsToMany('App\Models\PanunoteQuiz', 'panunote_quizlikes', 'user_id', 'quiz_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function panunoteSubjects()
    {
        return $this->belongsToMany('App\Models\PanunoteSubject', 'panunote_subjectlikes', 'user_id', 'subject_id');
    }
    public $timestamps = false;

}
