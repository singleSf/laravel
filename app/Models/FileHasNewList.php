<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class FileHasNewList
 *
 *
 * @property int id
 * @property int file_id
 * @property int new_list_id
 * @package App\Models
 */
class FileHasNewList extends Model
{
    use HasFactory;
}
