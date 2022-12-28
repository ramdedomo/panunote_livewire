<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $note_id
 * @property integer $subject_id
 * @property integer $user_id
 * @property string $note_content
 * @property boolean $note_sharing
 * @property string $note_tags
 * @property string $note_title
 * @property string $updated_at
 * @property string $created_at
 * @property PanunoteNotelike[] $panunoteNotelikes
 * @property PanunoteUser $panunoteUser
 * @property PanunoteSubject $panunoteSubject
 * @property PanunoteQuiz[] $panunoteQuizzes
 */
class PanunoteNotes extends Model
{
    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'note_id';

    /**
     * @var array
     */
    protected $fillable = ['subject_id', 'user_id', 'note_content', 'note_sharing', 'note_tags', 'note_title', 'updated_at', 'created_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function panunoteNotelikes()
    {
        return $this->hasMany('App\Models\PanunoteNotelike', 'note_id', 'note_id');
    }

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
    public function panunoteSubject()
    {
        return $this->belongsTo('App\Models\PanunoteSubject', 'subject_id', 'subject_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function panunoteQuizzes()
    {
        return $this->hasMany('App\Models\PanunoteQuiz', 'note_id', 'note_id');
    }

    public static function searchall($search)
    {
        return empty($search) ? static::query()
            : static::query()->where('user_id', session('USER_ID'))
            ->where('note_title', 'like', '%'.$search.'%')
                ->orWhere(function ($query) use ($search) {
                    $query->where('user_id', 'like', '%'.$search.'%')
                          ->where('note_tags', 'like', '%'.$search.'%')
                          ->where('note_id', 'like', '%'.$search.'%')
                          ->where('subject_id', 'like', '%'.$search.'%');
                });
    }


    public static function search($search)
    {
        return empty($search) ? static::query()
            : static::query()->where('panunote_notes.note_sharing', 1)
                ->where('panunote_notes.note_title', 'like', '%'.$search.'%')
                ->orWhere(function ($query) use ($search) {
                    $query->where('panunote_notes.user_id', 'like', '%'.$search.'%')
                          ->where('panunote_notes.note_tags', 'like', '%'.$search.'%')
                          ->where('panunote_notes.note_id', 'like', '%'.$search.'%')
                          ->where('panunote_notes.subject_id', 'like', '%'.$search.'%');
                });
    }

}
