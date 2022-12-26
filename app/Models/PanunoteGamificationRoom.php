<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $game_id
 * @property integer $quiz_id
 * @property integer $game_capacity
 * @property integer $status
 * @property integer $is_private
 * @property string $password
 * @property string $game_description
 * @property string $game_difficulty
 * @property integer $time
 * @property integer $player_count
 * @property integer $item_count
 * @property string $game_ends
 * @property string $game_start
 * @property integer $current_count
 * @property integer $is_pause
 */
class PanunoteGamificationRoom extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'panunote_gamification_Room';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'game_id';

    /**
     * @var array
     */
    protected $fillable = ['game_id', 'quiz_id', 'game_capacity', 'status', 'is_private', 'password', 'game_description', 'game_difficulty', 'time', 'player_count', 'item_count', 'game_ends', 'game_start', 'current_count', 'is_pause'];

    public static function search($search)
    {
        return empty($search) ? static::query()
            : static::query()->where('game_id', 'like', '%'.$search.'%')
                ->orWhere('game_description', 'like', '%'.$search.'%');
    }

    public $timestamps = false;


}
