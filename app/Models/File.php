<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class File
 *
 * @property int    id
 * @property string extension
 * @property int    size
 * @package App\Models
 */
class File extends Model
{
    use HasFactory;

    public function getPath(): string
    {
        return '/storage/public/new-list/'.$this->id.'.'.$this->extension;
    }

    public function getUri(): string
    {
        return $this->getPath();
    }
}
