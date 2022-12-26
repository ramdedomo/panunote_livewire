<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $subject_id
 * @property integer $user_id
 * @property string $created_at
 * @property string $updated_at
 * @property PanunoteUser $panunoteUser
 * @property PanunoteSubject $panunoteSubject
 */
class PanunoteSubjectVisits extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'panunote_subjectvisits';

    /**
     * @var array
     */
    protected $fillable = ['subject_id', 'user_id', 'created_at', 'updated_at'];

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
}
