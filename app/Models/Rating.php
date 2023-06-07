<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Rating
 *
 * @property int $id
 * @property int $new_list_id
 * @property int $rating
 * @package App\Models
 */
class Rating extends Model
{
    use HasFactory;
}
