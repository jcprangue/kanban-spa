<?php


namespace App\Services;

use App\Models\Task;
use Carbon\Carbon;

class TaskService
{
    public function index($request)
    {
        //fetch and group the task
        $tasks = Task::when($request->search, function ($query) use ($request) {
            $query->where('title', 'LIKE', $request->search . '%')
                ->orWhere('description', 'LIKE', $request->search . '%');
        })->orderBy('precedence')->get()->map(function ($query) {
            $status = config('kanban.kanban-status');
            return [
                "id" => $query->id,
                "title" => $query->tasks,
                "date" => Carbon::parse($query->due_date)->format("M d, Y"),
                "task_group" => $query->task_group,
                "status" => $status[$query->status]
            ];
        })->groupBy('status')->toArray();

        //format the result based on kanban
        $status = config('kanban.kanban-status');
        $result = collect($status)->map(function ($query) use ($tasks) {
            return [
                "title" => $query,
                "tasks" => isset($tasks[$query]) ? $tasks[$query] : []
            ];
        })->toArray();

        return $result;
    }

    public function store($request)
    {
        //format date
        $request->due_date = Carbon::parse($request->due_date)->format('Y-m-d H:i:s');
        if (!is_int($request->status)) {
            $_status = '';
            $status = collect(config('kanban.kanban-status'));
            foreach ($status as $key => $value) {
                if ($value == $request->status) {
                    $_status = $key;
                }
            }
        }
        $task = Task::create([
            "tasks" => $request->title,
            "description" => $request->description,
            "due_date" => $request->due_date,
            "status" => $_status,
            "task_group" => $request->task_group,
        ]);

        return $task;
    }

    public function update($request, $id)
    {
        $task = Task::findOrFail($id);
        $task->tasks = $request->title ?? '';
        $task->description = $request->description ?? '';
        //format date
        if (isset($request->due_date)) {
            $request->due_date = Carbon::parse($request->due_date)->format('Y-m-d H:i:s');
            $task->due_date = $request->due_date;
        }

        if (!is_int($request->status)) {
            $_status = '';
            $status = collect(config('kanban.kanban-status'));
            foreach ($status as $key => $value) {
                if ($value == $request->status) {
                    $_status = $key;
                }
            }
            $task->status = $_status;
        }

        $task->task_group = $request->task_group;
        $task->save();
        return $task;
    }

    public function sort($request)
    {
        if (!is_int($request->status)) {
            $_status = '';
            $status = collect(config('kanban.kanban-status'));
            foreach ($status as $key => $value) {
                if ($value == $request->status) {
                    $_status = $key;
                }
            }
        }

        foreach ($request->ids as $key => $value) {
            $task = Task::find($value);
            $task->precedence = $key;
            $task->save();
        }

        return $task;
    }
}
