<?php

namespace Modules\Files\Http\Controllers;

use MediaUploader;
use Plank\Mediable\Media;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class FilesController extends Controller
{
    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $file = MediaUploader::fromSource($request->file('file'))
                    ->toDisk('local')
                    ->toDirectory('files')
                    ->useHashForFilename()
                    ->setAllowedAggregateTypes(['image'])
                    ->upload();

        return response()->json(
            [
                'data' => [
                    'id' => $file->id,
                ],
                'meta' => generate_meta('success')
            ],
            200
        );
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show(Media $media)
    {
        throw_if(
            !Storage::exists($media->getDiskPath()),
            new ModelNotFoundException()
        );

        return response()->file($media->getAbsolutePath());
    }
}
