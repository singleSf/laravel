<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class NewList
 *
 * @property int    id
 * @property string $date
 * @property string $title
 * @property string $description
 * @property string $hash
 * @property int    $rating
 * @package App\Models
 */
class NewList extends Model
{
    use HasFactory;

    private ?File $file = null;

    private array $tags = [];

    /**
     * @return File|null
     */
    public function getFile(): ?File
    {
        return $this->file;
    }

    /**
     * @param File|null $_file
     */
    public function setFile(?File $_file): void
    {
        $this->file = $_file;
    }

    /**
     * @return array
     */
    public function getTags(): array
    {
        return $this->tags;
    }

    /**
     * @param array $_tags
     */
    public function setTags(array $_tags): void
    {
        $this->tags = $_tags;
    }

    public function addTag(NewTag $_tag): void
    {
        $this->tags[] = $_tag;
    }
}
