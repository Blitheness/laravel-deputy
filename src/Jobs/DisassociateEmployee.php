<?php

namespace Blitheness\Deputy\Jobs;

use Facades\Blitheness\Deputy\Models\Employee;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

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
        \Log::info('Constructing disassociation job');
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
        Employee::find($this->employee)->removeFromLocation($this->location);
    }
}
