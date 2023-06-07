<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\FileHasNewList;
use App\Models\NewList;
use App\Models\NewTag;
use App\Models\NewTagHasNewList;
use App\Models\Rating;

class NewListController extends Controller
{
    private const PER_PAGE = 5;

    public function index(int $_page = 1)
    {
        $statement = NewList::orderBy('rating', 'desc')->orderBy('date', 'desc')->paginate(self::PER_PAGE, ['*'], 'page', $_page);

        /** @var NewList[] $news */
        $news   = $statement->keyBy('id');
        $newIds = $news->modelKeys();

        if (!empty($newIds)) {
            // TODO SF: JOIN - must have. Sorry, there wasn't much time(
            /** @var FileHasNewList[] $hasesFiles */
            $hasesFiles = FileHasNewList::wherein('new_list_id', $newIds)->get();
            $fileIds    = array_column($hasesFiles->toArray(), 'file_id');

            /** @var NewTagHasNewList[] $hasesTags */
            $hasesTags = NewTagHasNewList::wherein('new_list_id', $newIds)->get();
            $tagIds    = array_column($hasesTags->toArray(), 'new_tag_id');

            if (!empty($tagIds)) {
                $tags = NewTag::wherein('id', $tagIds)->get()->keyBy('id');

                foreach ($hasesTags as $has) {
                    $new = $news[$has->new_list_id];
                    $tag = $tags[$has->new_tag_id];

                    $new->addTag($tag);
                }
            }

            if (!empty($fileIds)) {
                $files = File::wherein('id', $fileIds)->get()->keyBy('id');

                foreach ($hasesFiles as $has) {
                    $new  = $news[$has->new_list_id];
                    $file = $files[$has->file_id];

                    $new->setFile($file);
                }
            }
        }

        return view(
            'new-list',
            [
                'news'       => $news,
                'pagination' => [
                    'items' => $statement->total(),
                    'page'  => $_page,
                    'pages' => $statement->lastPage(),
                ],

            ]
        );
    }

    public function like(int $_page, int $_id)
    {
        $new = NewList::find($_id);
        $new->rating++;
        $new->save();

        $rating              = new Rating();
        $rating->new_list_id = $new->id;
        $rating->rating      = '1';
        $rating->save();

        return $this->index($_page);
    }

    public function dislike(int $_page, int $_id)
    {
        $new = NewList::find($_id);
        $new->rating--;
        $new->save();

        $rating              = new Rating();
        $rating->new_list_id = $new->id;
        $rating->rating      = '0';
        $rating->save();

        return $this->index($_page);
    }
}
