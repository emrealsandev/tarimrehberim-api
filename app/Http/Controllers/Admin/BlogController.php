<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Http\Resources\BlogResource;
use Validator;



class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Blog::all();
        $response = [
            'success' => true,
            'data' => BlogResource::collection($data),
            'message' => 'Blogs Fetched'
        ];
        return response()->json($response,200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'title' => 'required|string|max:255',
            'content' => 'required',
            'image' => 'string',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }

        $blogs = Blog::create([
            'title' => $request->title,
            'content' => $request->content,
            'image' => $request->image,
        ]);

        return response()->json(['Kayıt Başarıyla Eklendi', new BlogResource($blogs)]);


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $blog = Blog::find($id);
        if(is_null($blog)){
            return response()->json('Data not found',404);
        }
        return response()->json([new BlogResource($blog)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $blog = Blog::find($id);
        $input = $request->all();


        $validator = Validator::make($input,[
            'title' => $request->title,
            'content' => $request->content,
            'image' => $request->image,
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $blog->title = $input['title'];
        $blog->content = $input['content'];
        $blog->image = $input['image'];
        $blog->save();
        return response()->json(['Blog güncellendi', new BlogResource($blog)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Blog $blog)
    {
        $blog->delete();

        return response()->json('Bitki Başarıyla Silindi.');
    }
}
