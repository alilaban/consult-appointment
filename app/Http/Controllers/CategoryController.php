<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $experts_name = $request->query('experts');
        $categoryQuery = Category::query();

        if ($experts_name) {
            $categoryQuery = $categoryQuery->where('experts', $experts_name);
        }

        $categoryQuery = $categoryQuery->get();

        return response()->json([
            'success' => '1',
            'message' => 'Indexed successfully !!',
            'data' => $categoryQuery,
        ], 200);
        //'consult',
       // 'experts'
    }

    public function store(Request $request)
    {
        $request->validate([
         'experts' => ['required', 'string', 'max:255'],
         'consult' => ['required', 'string', 'max:255'],
        ]);
        $category = Category::query()->create([
            'experts' => $request['name'],
            'consult' => $request['consult']
        ]);
        return response()->json([
            'success' => '1',
            'message' => 'Category stored successfully !!',
            'data' => $category
        ], 200);

    }

    public function show($id)
    {
        $categoryQuery = Category::query();
        $categoryQuery = $categoryQuery->find($id);
        if( $categoryQuery)
        {
            return response()->json([
                'success' => '1',
                'message' => 'successfuly showed !!',
                'data' => $categoryQuery
            ], 200);
        }
        else{
            return response()->json([
                'success' => '0',
                'message' => 'Invalid id',
            ], 404);
        }
    }

    public function update(Request $request, $id,Category $category)
    {
        $category = $category->find($id);
        $request->validate([
            'experts' => ['required', 'string', 'max:255'],
            'consult' => ['required', 'string', 'max:255'],
           ]);
           //or #1
           $category->experts=$request['experts'];
           $category->consult=$request['consult'];
           $category->save();
        return response()->json([
            'success' => '1',
            'message' => 'Updated successfully !!',
            'data' => $category
        ], 200);
    }

    public function destroy($id,Category $category)
    {
        $category = $category->find($id);

        if($category){
            $category->experts()->delete();
            $category->delete();

            return response()->json([
                'success' => '1',
                'message' => 'Destroyed successfully !!',
            ], 200);
            }

            else
            {
                return response()->json([
                    'success' => '0',
                    'message' => 'Invalid id',
                ], 404);
            }
    }
}

//#1
   /*  if ($request['experts'])
           $category->update([
               'experts' => $request['experts']
           ]);
           if ($request['consult'])
           $category->update([
               'consult' => $request['consult']
           ]);
*/
//CategoryController
