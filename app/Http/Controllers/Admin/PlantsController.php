<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Plant;
use App\Http\Resources\PlantResource;

class PlantsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Plant::all();
        $response = [
            'success' => true,
            'data' => PlantResource::collection($data),
            'message' => 'Plants Fetched'
        ];
        return response()->json($response,200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'name' => 'required|string|max:255',
            'description' => 'required',
            'region' => 'required|string|max:255',
            'image' => 'string',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }

        $plants = Plant::create([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $request->image,
            'region' => $request->region,
        ]);

        return response()->json(['Kayıt Başarıyla Eklendi', new PlantResource($plants)]);


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $plant = Plant::find($id);
        if(is_null($plant)){
            return response()->json('Data not found',404);
        }
        return response()->json([new PlantResource($plant)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $plant = Plant::find($id);
        $input = $request->all();


        $validator = Validator::make($input,[
            'name' => 'required|string|max:255',
            'description' => 'required',
            'region' => 'required|string|max:255',
            'image' => 'string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $plant->name = $input['name'];
        $plant->description = $input['description'];
        $plant->region = $input['region'];
        $plant->image = $input['image'];
        $plant->save();
        return response()->json(['Bitki güncellendi', new PlantResource($plant)]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Plant $plant)
    {
        $plant->delete();

        return response()->json('Bitki Başarıyla Silindi.');
    }
}
