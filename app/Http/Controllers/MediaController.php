<?php

namespace App\Http\Controllers;

use App\Http\Requests\MediaRequest;
use App\Models\Album;
use App\Models\Media;
use App\Repositories\MediaRepository;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public $mediaRepository;

    public function __construct(MediaRepository $mediaRepository)
    {
        $this->mediaRepository = $mediaRepository;
    }

    /**
     * show media related to album
     *
     * @param int $id
     * @return response
     */
    public function index($id)
    {
        $album = Album::findOrFail($id);

        if (request()->ajax()) {
            $data = $album->getMedia('images')->map(function ($query) use ($id){
                return [
                    'id' => $query->id,
                    'name' => $query->name,
                    'image' => $query->getUrl(),
                    'album_id' => $id,
                    'created_at' => $query->created_at->format('d-m-Y')
                ];
            });
            // dd($data);
            return datatables()->of($data)
                ->addColumn('action', function($row){
                    $btn = '';
                    $btn = '<a class="custom-btn blue-bc" href="'.route('media.edit' , ['id' => $row['id'] , 'album_id' => $row['album_id']]).'" style="margin-right:5px;">Edit</a>';
                    $btn = $btn.'<button class="custom-btn red-bc delete-btn" data-url="'.route('media.destroy' , ['id' => $row['id']]).'">Delete</button>';
                    
                    return $btn;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('media.index' , compact('id'));
    }

    /**
     * store new media for specific album
     *
     * @param MediaRequest $mediaRequest
     * @param int $id
     * @return response
     */
    public function store(MediaRequest $mediaRequest , $id)
    {
        $mediaRequest['album_id'] = $id;
        try {
            $this->mediaRepository->create($mediaRequest->all());

            return response()->json([
                'message' => 'Image added successfully',
                'url' => route('media.index' , ['id' => $id])
            ] , 200);
        } catch (\Throwable $th) {
            return response()->json('Error , please try again later' , 400);
        }
    }

    /**
     * show edit page for media
     *
     * @param Album $album_id
     * @param Int $id
     * @return response
     */
    public function edit($album_id , $id)
    {
        $media = Media::findOrFail($id);

        return view('media.edit' , compact('id' , 'album_id' , 'media'));
    }

    /**
     * Undocumented function
     *
     * @param MediaRequest $mediaRequest
     * @param Album $album_id
     * @param Int $id
     * @return void
     */
    public function update(MediaRequest $mediaRequest ,$album_id ,$id)
    {
        $mediaRequest['album_id'] = $album_id;
        $mediaRequest['id'] = $id;

        try {
            $this->mediaRepository->edit($mediaRequest->all());

            return response()->json([
                'message' => 'Image updated successfully',
                'url' => route('media.index' , ['id' => $album_id])
            ] , 200);
        } catch (\Throwable $th) {
            return response()->json('Error , please try again later' , 400);
        }
    }

    public function destroy($id)
    {
        Media::findOrFail($id)->delete();
        
        return redirect()->back();
    }
}
