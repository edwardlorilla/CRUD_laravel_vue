<?php

namespace App\Http\Controllers;

use App\Photo;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::with('categories', 'photo')->latest()->orderBy('updated_at', 'desc')->get();
        return response()->json([
            'posts' => $posts
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $items = array();
        foreach($request->value as $value) {
            $items[] = $value['id'];
        }
        $user = Auth::user();
            $input = $request->all();
            if ($file = $request->img) {
                list($type, $imageData) = explode(';', $request->img);
                list(, $extension) = explode('/', $type);
                list(, $imageData) = explode(',', $imageData);
                $fileName = uniqid() . '.' . $extension;
                $source = fopen($request->img, 'r');
                $destination = fopen('images/' . $fileName, 'w');
                stream_copy_to_stream($source, $destination);
                fclose($source);
                fclose($destination);
                $photo = Photo::create(['file' => $fileName]);
                $input['photo_id'] = $photo->id;
            }
        $user->posts()->create($input)->categories()->attach($items);
        return response()->json(['success' => true, 'message'=>'Create Post']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $posts = Post::with('categories')->findOrfail($id);
        return response()->json([
            'posts' => $posts
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $post = Auth::user()->posts()->whereId($id)->first();
        $input = $request->all();
        if ($file = $request->img) {
            list($type, $imageData) = explode(';', $request->img);
            list(, $extension) = explode('/', $type);
            list(, $imageData) = explode(',', $imageData);
            $fileName = uniqid() . '.' . $extension;
            $source = fopen($request->img, 'r');
            $destination = fopen('images/'.$fileName, 'w');
            stream_copy_to_stream($source, $destination);
            fclose($source);
            fclose($destination);
            $photo = Photo::create(['file' => $fileName]);
            $input['photo_id'] = $photo->id;
        }
        $post->update($input );
        return response()->json(['success' => true, 'message' => "User updated"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request , $id = null)
    {
        if ($request->id) {
            foreach ($request->id as $id) {
                $post = Post::findOrFail($id);
                if ($post->photo) {
                    unlink(public_path() . $post->photo->file);
                }
                $post->delete();
            }
        }
    }



}
