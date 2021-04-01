<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;
use App\Models\User;
use App\Http\Resources\TodoResource;

class TodoController extends Controller
{

    public function index()
    {
        $todos = Todo::all();
        $users = User::all();

        return TodoResource::collection(['todos'=>$todos, 'users'=>$users]);

    }

    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $this->validate($request, ['title'=>'required', 'deadline'=>'required']);

        $todo = Todo::create($request->all());
        
        return new TodoResource($todo);

    }

    public function show($id)
    {
        $todo = Todo::findOrFail($id);

        return new TodoResource($todo);

    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, ['title'=>'required', 
                                    'status'=>'required', 
                                    'deadline'=>'required']);

        $todo = Todo::findOrFail($id)->update($request->all());
        
        return response()->json( ['success'=>true]);

    }


    public function destroy($id)
    {
        $td = Todo::findOrFail($id);
        $td->delete();

    }
}
