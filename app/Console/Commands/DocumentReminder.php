<?php

namespace App\Console\Commands;

use App\Http\Controllers\TaskController;
use App\Http\Requests\TaskRequest;
use App\Models\Document;
use App\Models\DocumentVersion;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocumentReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'document:reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reminder document expiry';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $expiredDate = Carbon::now()->addDays(30)->format('Y-m-d');
        $documents = DocumentVersion::where('expired_date', $expiredDate)->get();

        foreach ($documents as $document)
        {
            $this->info($document->document->title);
            $this->error($document->expired_date);
            $this->line('-------------------------');
            Auth::login($document->owner);

            $request = new TaskRequest([
                'title' => "Document Renewal : {$document->document->title}",
                'description' => 'Please renew this document.',
                'assignees' => [$document->owner_id],
                'document_id' => $document->document_id,
                'type' => Task::TYPE_DOCUMENT_REVIEW,
                'priority' => Task::PRIORITY_HIGH,
                'due_date' => $document->expired_date
            ]);

            $controller = app()->make(TaskController::class);
            app()->call([$controller, 'store'], ['request' => $request]);
        }

    }
}
