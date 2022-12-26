<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $user_id
 * @property integer $note_id
 * @property string $updated_at
 * @property string $created_at
 * @property PanunoteUser $panunoteUser
 * @property PanunoteNote $panunoteNote
 */
class PanunoteNoteVisits extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'panunote_notevisits';

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'note_id', 'updated_at', 'created_at'];

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
    public function panunoteNote()
    {
        return $this->belongsTo('App\Models\PanunoteNote', 'note_id', 'note_id');
    }
}
