<?php

namespace App\Repositories;

use App\Models\Album;

class AlbumRepository 
{
   public $model;

   public function __construct(Album $model)
   {
      $this->model = $model;
   }

   public function create($request)
   {
      $album = $this->model->create(['name' => $request['name']]);

      // foreach ($request['images'] as $image) {
      //    $album->addMedia($image)
      //    ->toMediaCollection('images' , 'media');
      // }
      
   }

   public function edit($request,$album)
   {
      $album->update($request);
   }
}