<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTask;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Services\TaskService;
use App\Traits\FormatResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    use FormatResponse;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, TaskService $taskService)
    {
        try {
            $data = $taskService->index($request);
            return $this->formatSuccessResponse(
                $data,
                "Successfully fetch tasks record"
            );
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            return $this->errorResponse(
                'Failed to fetch tasks record.'
            );
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTask $request, TaskService $taskService)
    {
        try {
            $data = $taskService->store($request);
            return $this->formatSuccessResponse(
                $data,
                "Successfully store tasks"
            );
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            return $this->errorResponse(
                'Failed to store tasks.'
            );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $data = Task::findOrFail($id);
            return $this->formatSuccessResponse(
                new TaskResource($data),
                "Successfully fetch tasks"
            );
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            return $this->errorResponse(
                'Failed to fetch tasks.'
            );
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreTask $request, $id, TaskService $taskService)
    {
        try {
            $data = $taskService->update($request, $id);

            return $this->formatSuccessResponse(
                $data,
                "Successfully update tasks"
            );
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            return $this->errorResponse(
                'Failed to update tasks.'
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $data = Task::find($id);
            $data->delete();

            return $this->formatSuccessResponse(
                $data,
                "Successfully delete tasks"
            );
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            return $this->errorResponse(
                'Failed to delete tasks.'
            );
        }
    }
}
