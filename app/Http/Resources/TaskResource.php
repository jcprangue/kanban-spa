<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $status = config('kanban.kanban-status');
        return [
            'id' => $this->id,
            'title' => $this->tasks,
            'description' => $this->description,
            'due_date' => Carbon::parse($this->due_date)->format('Y-m-d'),
            'status' => $status[$this->status],
            'task_group' => $this->task_group
        ];
    }
}
