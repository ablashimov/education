<?php

namespace App\Http\Resources\Group;

use App\Http\Resources\Course\Exam\ExamResource;
use App\Models\GroupExamSchedule;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExamScheduleResource extends JsonResource
{
    /**
     * @var GroupExamSchedule $resource
     */
    public $resource;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'exam_id' => $this->resource->exam_id,
            'start_date' => $this->resource->start_at,
            'end_date' => $this->resource->end_at,
            'exam' => ExamResource::make($this->resource->exam),
            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at,
        ];
    }
}
