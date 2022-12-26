<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $user_id
 * @property integer $subject_id
 * @property integer $subject_like
 * @property string $updated_at
 * @property string $created_at
 * @property PanunoteSubject $panunoteSubject
 * @property PanunoteUser $panunoteUser
 */
class PanunoteSubjectLikes extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'panunote_subjectlikes';

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'subject_id', 'subject_like', 'updated_at', 'created_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function panunoteSubject()
    {
        return $this->belongsTo('App\Models\PanunoteSubject', 'subject_id', 'subject_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function panunoteUser()
    {
        return $this->belongsTo('App\Models\PanunoteUser', 'user_id', 'user_id');
    }
}
