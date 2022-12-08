<?php

namespace App\Repositories;

use App\Http\Resources\AlbumResource;
use App\Models\Album;

class AlbumRepository 
{
   public $model;

   public function __construct(Album $model)
    {
      $this->model = $model;
    }

   public function listAll()
   {
      $objects = $this->model->all()->sortBy('id' , SORT_REGULAR);
 
      return AlbumResource::collection($objects)->response()->getData(true);
   }

   public function showById(Album $album)
   {
      return (new AlbumResource($album))->resolve();
   }

   public function create($request)
   {
      $album = $this->model->create(['name' => $request->name]);

      $album->addFromMediaLibraryRequest($request->get('images'))
      ->toMediaCollection('images');
   }

   public function edit($request , Album $album)
   {
      $album->update($request);
   }
}