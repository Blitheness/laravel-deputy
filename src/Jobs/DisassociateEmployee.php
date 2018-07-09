<?php

namespace Blitheness\Deputy\Jobs;

use Facades\Blitheness\Deputy\Models\Employee;
use Facades\Blitheness\Deputy\Models\EmployeeWorkplace as Workplace;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Collection;

class DisassociateEmployee implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $employee;
    protected $location;

    /**
     * Create a new job instance.
     *
     * @param  int  $deputyId
     * @return void
     */
    public function __construct(int $employee, int $location) {
        $this->employee = $employee;
        $this->location = $location;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        \Log::info('Attempting to disassociate Deputy employee ' . $this->employee . ' from location ' . $this->location);
        $employee   = Employee::find($this->employee);
        $workplaces = Workplace::search('EmployeeId', 'eq', $employee->Id)->get();
        if(
            (get_class($workplaces) == 'Blitheness\\Deputy\\Models\\EmployeeWorkplace') ||
            ($workplaces instanceof Collection && $workplaces->count() == 1)
        ) {
            // Employee has only one place of work; terminate.
            \Log::info('[Deputy] Employee had only 1 workplace, so the employee has been terminated.');
            $employee->terminate();
        } else {
            // Disassociate employee from specified location
            \Log::info('[Deputy] Removing employee ' . $employee->DisplayName . ' from location ' . config('deputy.companies.' . $this->location, $this->location));
            $employee->removeFromLocation($this->location);
            if(config('deputy.terminate_if_only_in_default', false)) {
                if(config('deputy.default_company', 0) != 0 && $workplaces->count() == 2) {
                    foreach($workplaces as $w) {
                        if($w->Company == $this->location) continue;
                        if($w->Company == config('deputy.default_company')) {
                            \Log::info('[Deputy] Only remaining workplace of ' . $employee->DisplayName . ' was the default workplace, so the employee has been terminated.');
                            $employee->terminate();
                        }
                    }
                }
            }
        }
    }
}
