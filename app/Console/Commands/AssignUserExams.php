<?php

namespace App\Console\Commands;

use App\Actions\Group\Exams\AssignUserExams as AssignUserExamsAaction;
use App\Actions\Group\Exams\GetScheduledExams;
use Carbon\Carbon;
use Illuminate\Console\Command;

class AssignUserExams extends Command
{
    protected $signature = 'exams:assign';

    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(AssignUserExamsAaction $action, GetScheduledExams $getScheduledExams)
    {
        $schedules = $getScheduledExams->execute(Carbon::now());

        foreach ($schedules as $schedule) {
            $action->execute($schedule);
        }
    }
}
