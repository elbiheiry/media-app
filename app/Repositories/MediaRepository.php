<?php

namespace App\Repositories;

use App\Models\Album;
use App\Models\Media;

class MediaRepository 
{
   public $model;

   public function __construct(Album $model)
   {
      $this->model = $model;
   }

   public function create($request)
   {
      $album = $this->model->findOrFail($request['album_id']);
      $album->addMedia($request['image'])->usingName($request['name'])->toMediaCollection('images' , 'media');
   }

   public function edit($request)
   {
      $album = $this->model->findOrFail($request['album_id']);
      Media::findOrFail($request['id'])->delete();
      $album->addMedia($request['image'])->usingName($request['name'])->toMediaCollection('images' , 'media');
   }
}