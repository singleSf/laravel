<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class NewTagHasNewList
 *
 * @property int $id
 * @property int $new_tag_id
 * @property int $new_list_id
 * @package App\Models
 */
class NewTagHasNewList extends Model
{
    use HasFactory;
}
