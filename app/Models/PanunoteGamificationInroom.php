<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $user_id
 * @property integer $game_id
 * @property integer $score
 * @property integer $role
 * @property integer $user_status
 */
class PanunoteGamificationInroom extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'panunote_gamification_Inroom';

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'game_id', 'score', 'role', 'user_status'];
}
