<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddIngredientRequest;
use App\Http\Requests\deleteRequest;
use App\Http\Requests\ingredientRequest;
use App\Http\Requests\recipedetails;
use App\Http\Requests\saveRequest;
use App\Http\Requests\userRequest;
use App\Models\AddIngredient;
use App\Models\ingredient;
use Illuminate\Http\Request;
use App\Models\recipeModel;

class recipeController extends Controller
{
    public function addrecipe(userRequest $userRequest)
    {
        $user = new recipeModel();
        $user->recipe_name = $userRequest->get('recipe_name');
        $user->cuisine = $userRequest->get('cuisine');
        $user->description = $userRequest->get('description');
        $user->chef = $userRequest->get('chef');
        $user->save();
        return response()->json(['status' => true, "message" => "Recipe details created!"]);
    }

    public function getrecipes()
    //get recipe list
    {
        $users = recipeModel::get();
        return response()->json([
            "status" => true,
            "data" => $users
        ]);
    }
    //get particular recipe details on click of button
    public function recipedetails(recipedetails $recipedetails)
    {
        $id = $recipedetails->get('id');
        $details = recipeModel::where('id', $id)->first();
        return response()->json([
            "status"=>true,
            "data"=>$details,
        ]);
    }
    //delete particular row details on click on button
    public function deleteRecipe(deleteRequest $deleteRequest)
    {
        $id = $deleteRequest->get('id');
        $deleteRequest = recipeModel::where('id', $id)->delete();
        return response()->json([
            "status" => true,
            "message"=>"Deleted successfully!"
        ]);
    }
  public function saveRequest(saveRequest $saveRequest,recipeModel $recipeModel)
  {
        $recipeModel->update($saveRequest->all()["recipe_details"]);
        return response()->json(['status' => true, 'message' => "Recipe updated!"]);
    }
    public function addIngredient(AddIngredientRequest $request){
         
        if (AddIngredient::where('recipe_id', $request->get('recipe_id'))->where('ingredient_id', $request->get('ingredient_id'))->exists()) {
            return response()->json(['status' => false, "message" => "Ingredients added to recipe already!"]);
        }

        $user = new AddIngredient();
        $user->recipe_id = $request->get('recipe_id');
        $user->ingredient_id = $request->get('ingredient_id');
        $user->save();

        return response()->json(['status' => true, "message" => "Added ingredient!"]);
    }
    public function getingredients()
    //get  ingredient list into select box
    {
        $users = ingredient::get();
        return response()->json([
            "status" => true,
            "data" => $users
        ]);
    }
    //get selected ingredient list into database
    public function selectedingredient(ingredientRequest $request)
    {
        try{
            $recipe = recipeModel::where('id', $request->get('recipe_id'))->first();
            $integredints = $request->get('ingredients');

            $recipe->ingredients()->attach($integredints);
            return response()->json(["status" => true,"message"=>"Ingredients added!"]);

        } catch(\Throwable $e){
            return response()->json(["status" => false, "message" => $e->getMessage()]);
        }
    }
    }

