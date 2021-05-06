<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Exception;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Items = Task::orderBy('id', 'DESC')->get();
        return $Items;
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
     * @param Request $request
     * @return Exception|\Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'   => 'required',
            'status' => 'required',
        ]);
        try {
            Task::create([
                'name'   => $request->name,
                'status' => $request->status,
            ]);
            return response()->json(['success' => 'Yah! a task has been successfully created.', 'status' => 200]);
        } catch (Exception $exception) {
            return $exception;
        }
    }

    public function status($id, $status)
    {
        $Task = Task::find($id);
        if ($Task->status == 'active') {
            $Task->status = 'inactive';
        } else {
            $Task->status = 'active';
        }
        $Task->update();
        return response(['success' => 'Status Successfully changed'], 200);
    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * @param Request $request
     * @param         $id
     * @return Exception|\Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);
        try {
            $TaskUpdate         = Task::findOrfail($id);
            $TaskUpdate->name   = $request->name;
            $TaskUpdate->status = $request->status;
            $TaskUpdate->update();
            return response()->json(['success' => 'Task Successfully Updated.'], 200);

        } catch (Exception $exception) {
            return $exception;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Task::destroy($id);
        return response(['success' => "Yah a Task has been successfully deleted."]);
    }
}
