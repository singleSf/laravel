<?php

namespace App\Console\Commands;

use App\Models\File;
use App\Models\FileHasNewList;
use App\Models\NewList;
use App\Models\NewTag;
use App\Models\NewTagHasNewList;
use DateTime;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class NewsParse extends Command
{
    private const RELATION_XML = 'https://lenta.ru/rss/news';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:news-parse';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $xml         = simplexml_load_file(self::RELATION_XML);
        $disk        = Storage::disk('local');
        $countImport = 0;

        foreach ($xml->channel->item as $item) {
            $date        = (new DateTime($item->pubDate))->format('Y-m-d');
            $title       = trim($item->title);
            $description = trim((string)$item->description);
            $tagTitle    = trim($item->category);

            $hash = md5(
                implode(
                    [
                        $date,
                        $title,
                    ]
                )
            );

            $remotePath = (string)$item->enclosure['url'];
            $extension  = strtolower(pathinfo($remotePath, PATHINFO_EXTENSION));

            if (!in_array(
                $extension, [
                    'jpg',
                    'png',
                ]
            )) {
                continue;
            }
            if (NewList::where('hash', $hash)->exists()) {
                continue;
            }

            $statement = NewTag::where('title', $tagTitle);
            $tag       = $statement->first();
            if (!$statement->exists()) {
                $tag        = new NewTag();
                $tag->title = $tagTitle;
                $tag->save();
            }

            $new              = new NewList();
            $new->date        = $date;
            $new->title       = $title;
            $new->description = $description;
            $new->hash        = $hash;
            $new->rating      = 0;
            $new->save();

            $newTagHasNewList              = new NewTagHasNewList();
            $newTagHasNewList->new_tag_id  = $tag->id;
            $newTagHasNewList->new_list_id = $new->id;
            $newTagHasNewList->save();

            $fileContent     = file_get_contents($remotePath);
            $file            = new File();
            $file->extension = $extension;
            $file->size      = strlen($fileContent);
            $file->save();
            $disk->put($file->getPath(), $fileContent);

            $fileHasNews              = new FileHasNewList();
            $fileHasNews->file_id     = $file->id;
            $fileHasNews->new_list_id = $new->id;
            $fileHasNews->save();

            $countImport++;
        }

        $this->info('На сайт было добавлено '.$countImport.' новостей');
    }
}
