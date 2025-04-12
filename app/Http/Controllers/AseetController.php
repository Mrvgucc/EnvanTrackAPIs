<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Http\Request;

class AseetController extends Controller
{
    public function assetInsert(Request $request){
        $validated = $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'registered_personal' => 'nullable',
        ]);

        $asset = Asset::create([
            'name' => $validated['name'],
            'category_id' => $validated['category_id'],
            'registered_personal' => $validated['registered_personal'] ?? null, // bos ise null olabilir
        ]);

        return response()->json([
            'message' => 'Asset inserted successfully.',
        ]);

    }

    public function assetUpdate(Request $request, $id){

        $validated = $request->validate([
            'name' => 'nullable',
            'category_id' => 'nullable',
            'registered_personal' => 'nullable',
        ]);

        $asset = Asset::find($id);

        if(!$asset){
            return response()->json([
                'message' => 'Asset not found.',
            ]);
        }

        if(isset($validated['name'])){ // gelen veride name degeri varsa guncelleme gerceklestirilir
            $asset->name = $validated['name'];
        }
        if(isset($validated['category_id'])){
            $asset->category_id = $validated['category_id'];
        }
        if(isset($validated['registered_personal'])){
            $asset->registered_personal = $validated['registered_personal'];
        }

        if (is_null($asset->registered_personal)) {
            $asset->usage_status = 'inactive';
        } else {
            $asset->usage_status = 'active';
        }

        $asset->save();


        return response()->json([
            'message' => 'Asset updated successfully.',
        ]);


    }

    public function assetDelete($id){

        $id = Asset::find($id);

        if(!$id){
            return response()->json([
                'message' => 'Asset not found.',
            ]);
        }

        $id->delete();

        return response()->json([
            'message' => 'Asset deleted successfully.',
        ]);


    }

    public function assetList(){
        $assets = Asset::all();
        return response()->json([
            'assets' => $assets,
        ]);
    }



}
