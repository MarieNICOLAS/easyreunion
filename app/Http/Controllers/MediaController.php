<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\Space;
use App\Models\SpaceGroup;
use App\Services\ImageService;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
        ]);

        $media = new Media();
        if ($request->input('youtubeurl')) {
            if (! preg_match('/^((?:https?:)?\/\/)?((?:www|m)\.)?((?:youtube\.com|youtu.be))(\/(?:[\w\-]+\?v=|embed\/|v\/)?)([\w\-]+)(\S+)?$/',
                $request->input('youtubeurl'))) {
                abort(403);
            }
            $media->name = 'Vidéo';
            $media->content = $request->input('youtubeurl');
            $media->type = 'youtube-video';
        } else {
            $path = $request->file('file')->store('public/media');
            $media->name = 'Image';
            $media->content = substr($path, 13);
            $media->type = 'image';

            // create thumb icon
            ImageService::createThumb($media->content);

        }

        if ($request->has('space_group')) {
            $sg = SpaceGroup::findOrFail($request->input('space_group'));
            $this->authorize('update', $sg);
            $media->space_group_id = $sg->id;
        }
        if ($request->input('space'))
        {
            $space = Space::findOrFail($request->input('space'));
            $this->authorize('update', $space->spaceGroup);
            $media->space_id = $space->id;
        }

        $media->save();

        ImageService::compressImgFromFile($media->content);
        ImageService::addWaterMark($media->content);

        return redirect()->back();
    }

    public function removeMedia(Request $request, Media $media)
    {
        $this->authorize('delete', $media);

        $media->delete();

        return response('OK');
    }

    public function editMediaOrder(Request $request, Media $media, $order)
    {
        $this->authorize('update', $media);

        $common_type = $media->space_group_id ? 'space_group' : ($media->space_id ? 'space' : null);
        if (! $common_type) abort(403);
        $common_id = $media->{$common_type . '_id'};

        if ($media->order !== $order)
        {
            if ($media->order < $order)
            {
                $medias_before = Media::where($common_type . '_id', $common_id)
                    ->where('order', '<', $order)
                    ->orderBy('order', 'desc')
                    ->get();

                foreach ($medias_before as $media_)
                {
                    $media_->order--;
                    $media_->save();
                }
            }

            else if ($media->order > $order)
            {
                $medias_after = Media::where($common_type . '_id', $common_id)
                    ->where('order', '>', $order)
                    ->orderBy('order', 'asc')
                    ->get();

                foreach ($medias_after as $media_)
                {
                    $media_->order++;
                    $media_->save();
                }
            }

            $media->order = $order;
            $media->save();
        }

        return response()->json([
            'status' => 'Success'
        ]);
    }


    public function reorderMedia(Request $request) {
        $queryString = $request->getContent();
        $queryParams = explode(',', $queryString);

        foreach ($queryParams as $element) {
            $el = explode(':', $element);
            $id = $el[1];
            $order = $el[0];

            $media = Media::find($id);

            $media->order = $order;
            $media->save();

            $result[] = $media->order.':'.$media->id;
        }

        return response()->json([$queryString, $result]);
    }

    public function tinyMCE(Request $request)
    {
        $path = $request->file('file')->store('public/media');

        return response()->json(['location' => '/' . str_replace('public', 'storage', $path)]);
    }
}
