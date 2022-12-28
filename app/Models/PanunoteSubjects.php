<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $subject_id
 * @property integer $user_id
 * @property string $subject_name
 * @property boolean $subject_sharing
 * @property string $updated_at
 * @property string $created_at
 * @property PanunoteNote[] $panunoteNotes
 * @property PanunoteSubjectlike[] $panunoteSubjectlikes
 * @property PanunoteUser $panunoteUser
 */
class PanunoteSubjects extends Model
{
    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'subject_id';

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'subject_name', 'subject_sharing', 'updated_at', 'created_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function panunoteNotes()
    {
        return $this->hasMany('App\Models\PanunoteNote', 'subject_id', 'subject_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function panunoteSubjectlikes()
    {
        return $this->hasMany('App\Models\PanunoteSubjectlike', 'subject_id', 'subject_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function panunoteUser()
    {
        return $this->belongsTo('App\Models\PanunoteUser', 'user_id', 'user_id');
    }

    public static function searchall($search){
        return empty($search) ? static::query()
        : static::query()->where('user_id', session('USER_ID'))
        ->where('subject_name', 'like', '%'.$search.'%')
            ->orWhere(function ($query) use ($search) {
                $query->where('user_id', 'like', '%'.$search.'%')
                      ->where('subject_id', 'like', '%'.$search.'%');
            });
    }
    

    public static function search($search)
    {
        return empty($search) ? static::query()
            : static::query()->where('panunote_subjects.subject_sharing', 1)
                ->where('panunote_subjects.subject_name', 'like', '%'.$search.'%')
                ->orWhere(function ($query) use ($search) {
                    $query->where('panunote_subjects.user_id', 'like', '%'.$search.'%')
                          ->where('panunote_subjects.subject_id', 'like', '%'.$search.'%');
                });
    }

}
