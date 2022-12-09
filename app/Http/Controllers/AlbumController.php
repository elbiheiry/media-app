<?php

namespace App\Http\Controllers;

use App\Http\Requests\AlbumRequest;
use App\Models\Album;
use App\Repositories\AlbumRepository;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    public $albumRepository;

    public function __construct(AlbumRepository $albumRepository)
    {
        $this->albumRepository = $albumRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $albums = Album::all()->sortByDesc('id');
        if (request()->ajax()) {
            $data = Album::withCount('media')->get()->map(function ($query){
                return [
                    'id' => $query->id,
                    'name' => $query->name,
                    'media_count' => $query->media_count,
                    'created_at' => $query->created_at->format('d-m-Y')
                ];
            });
            return datatables()->of($data)
                ->addColumn('action', function($row){
                    $btn = '';
                    $btn = '<a class="custom-btn green-bc" href="'.route('media.index' , ['id' => $row['id']]).'" style="margin-right:5px;">Media</a>';
                    $btn = $btn.'<a class="custom-btn blue-bc" href="'.route('album.edit' , ['album' => $row['id']]).'" style="margin-right:5px;">Edit</a>';
                    if ($row['media_count'] == 0) {
                        $btn = $btn.'<button class="custom-btn red-bc delete-btn" data-url="'.route('album.destroy' , ['album' => $row['id']]).'">Delete</button>';
                    }else{
                        $btn = $btn.'<button class="custom-btn red-bc update-btn" data-id="'.$row['id'].'" data-url="'.route('album.change' , ['id' => $row['id']]).'">Delete</button>';
                    }
                    return $btn;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('albums.index' , compact('albums'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Album $album
     * @return \Illuminate\Http\Response
     */
    public function edit(Album $album)
    {
        if (request()->ajax()) {
            $data = $album->getMedia('images')->map(function ($query){
                return [
                    'id' => $query->id,
                    'name' => $query->name,
                    'image' => $query->getUrl(),
                    'album_id' => $query->model_id,
                    'created_at' => $query->created_at->format('d-m-Y')
                ];
            });
            return datatables()->of($data)
                ->addColumn('action', function($row){
                    $btn = '';
                    $btn = '<a class="custom-btn blue-bc" href="'.route('media.edit' , ['album_id' => $row['album_id'] , 'id' => $row['id']]).'" style="margin-right:5px;">Edit</a>';
                    $btn = $btn.'<button class="custom-btn red-bc delete-btn" data-url="'.route('media.destroy' , ['id' => $row['id']]).'">Delete</button>';
                    
                    return $btn;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('albums.edit' , compact('album'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  AlbumRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AlbumRequest $request)
    {
        try {
            $this->albumRepository->create($request->all());

            return response()->json(['message' => 'Album created successfully'], 200);
        } catch (\Throwable $th) {
            return response()->json('Error , please try again later' , 400);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  AlbumRequest  $request
     * @param  Album $album
     * @return \Illuminate\Http\Response
     */
    public function update(AlbumRequest $request , Album $album)
    {
        try {
            $this->albumRepository->edit($request->all() , $album);

            return response()->json(['message' => 'Album data updated successfully'] , 200);
        } catch (\Throwable $th) {
            return response()->json('Error , please try again later' , 400);
        }
    }

    /**
     * delete album
     *
     * @param Album $album
     * @return response
     */
    public function destroy(Album $album)
    {
        $album->delete();

        return redirect()->back();
    }

    /**
     * draw chart for all albums
     *
     * @return response
     */
    public function chart()
    {
        $data = Album::withCount('media')->orderBy('id' , 'desc')->get();

        return response()->json($data);
    }

    public function changeAlbumId(Request $request, $id)
    {
        $album = Album::findOrFail($id);

        try {
            if ($request->album_id == 0) {
                $album->delete();
            }else{
                $album->media()->update([
                    'model_id' => $request->album_id
                ]);
                $album->delete();
            }
    
            return response()->json(['message' => 'Album deleted successfully'], 200);
        } catch (\Throwable $th) {
            return response()->json('Error , please try again later' , 400);
        }
        
    }
}
