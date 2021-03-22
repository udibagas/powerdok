<?php

namespace App\Http\Controllers;

use App\Events\ApprovalCompletedEvent;
use App\Events\ApprovalRequestEvent;
use App\Events\DocumentFinalizedEvent;
use App\Events\DocumentPublishedEvent;
use App\Events\DocumentUpdatedEvent;
use App\Events\NewCommentEvent;
use App\Events\NewTaskEvent;
use App\Events\TaskApprovedEvent;
use App\Events\TaskFinishedEvent;
use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskCollection;
use App\Models\Document;
use App\Models\Task;
use App\Models\TaskApproval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return new TaskCollection(
            Task::with(['attachments'])->where(function ($q) {
                $q->where('user_id', auth()->id())
                    ->orWhere('assignee_id', auth()->id());
            })->when($request->owned, function ($q) {
                return $q->where('user_id', auth()->id());
            })->when($request->assigned, function ($q) {
                return $q->where('assignee_id', auth()->id());
            })->when($request->type, function ($q) use ($request) {
                $q->whereIn('type', $request->type);
            })->when($request->priority, function ($q) use ($request) {
                $q->whereIn('priority', $request->priority);
            })->when($request->status, function ($q) use ($request) {
                $q->whereIn('status', $request->status);
            })->when($request->keyword, function ($q) use ($request) {
                $q->where(function ($q) use ($request) {
                    $q->where('title', 'ILIKE', "%{$request->keyword}%")
                        ->orWhere('description', 'ILIKE', "%{$request->keyword}%")
                        ->orWhereHas('assignee', function ($q) use ($request) {
                            $q->where('name', 'ILIKE', "%{$request->keyword}%");
                        });
                });
            })->orderBy(
                $request->sort_field ?: 'updated_at',
                $request->sort_direction ? $request->sort_direction : 'desc'
            )->paginate($request->per_page)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaskRequest $request)
    {
        $tasks = DB::transaction(function () use ($request) {
            $tasks = [];

            foreach ($request->assignees as $assignee) {
                $task = Task::create(array_merge(
                    $request->all(),
                    ['user_id' => auth()->id(), 'assignee_id' => $assignee]
                ));

                if ($request->attachments) {
                    $task->attachments()->createMany($request->attachments);
                }

                if ($request->type == Task::TYPE_EXAMINATION) {
                    $task->document->exams()->create([
                        'task_id' => $task->id,
                        'user_id' => $assignee,
                        'exam_minimum_score' => $task->document->exam_minimum_score,
                        'exam_max_duration' => $task->document->exam_max_duration,
                        'quizzes' => $task->document->quizzes->map(function ($item) {
                            return [
                                'question' => $item->question,
                                'choices' => $item->choices,
                                'correct_answer' => $item->correct_answer,
                                'user_answer' => null,
                                'attachments' => $item->attachments->map(function ($attachment) {
                                    return $attachment->url;
                                })
                            ];
                        })->shuffle()->all()
                    ]);
                }

                $tasks[] = $task;
            }

            return $tasks;
        });

        foreach ($tasks as $task) {
            event(new NewTaskEvent($task));
        }

        return ['message' => 'Data has been saved'];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        $this->authorize('view', $task);

        return $task->load([
            'user',
            'assignee',
        ]);
    }

    /**
     * Update the specifphp artisan stub:publishied resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(TaskRequest $request, Task $task)
    {
        $this->authorize('update', $task);

        $task = DB::transaction(function () use ($request, $task) {
            $task->update($request->all());

            if ($request->attachments) {
                $task->attachments()->createMany($request->attachments);
            }
        });

        return ['message' => 'Data has been updated', 'data' => $task];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);

        DB::transaction(function () use ($task) {
            $task->attachments()->delete();
            $task->delete();
        });

        // TODO: notify to assignee task has been deleted

        return ['message' => 'Data has been deleted', 'data' => $task];
    }

    public function updateDocument(Task $task, Request $request)
    {
        $this->authorize('updateDocument', $task);

        $request->validate([
            'title' => 'required',
            'type' => 'required',
            'body' => 'required'
        ]);

        if (!$task->document_id) {
            $document = Document::create($request->all());
            $document->versions()->create([
                'body' => $request->body,
                'owner_id' => auth()->id(),
                'status' => $request->status ?: 0
            ]);

            $task->update([
                'document_id' => $document->id,
                'status' => Task::STATUS_ON_PROGRESS
            ]);
        } else {
            $task->document->update([
                'title' => $request->title,
                'type' => $request->type
            ]);
            $task->document->latest_version->update(['body' => $request->body]);
        }

        event(new DocumentUpdatedEvent($task));

        return ['message' => 'Document has been saved'];
    }

    public function finalizedDocument(Task $task)
    {
        // $this->authorize('finalizedDocument', $task);

        $task->update(['status' => Task::STATUS_FINALIZED]);

        event(new DocumentFinalizedEvent($task));

        return ['message' => 'Document has been finalized'];
    }

    public function publishDocument(Request $request, Task $task)
    {
        // $this->authorize('publishDocument', $task);
        $request->validate([
            'number' => 'required',
            'version' => 'required',
            'effective_date' => 'required',
            'expired_date' => 'required',
            'categories' => 'required',
            'tags' => 'required',
            'departments' => 'required'
        ]);

        $task->document->update($request->all());
        $task->document->latest_version->update($request->all());
        $task->update(['status' => Task::STATUS_FINISHED]);

        event(new DocumentPublishedEvent($task));

        return ['message' => 'Document has been published'];
    }

    public function requestApproval(Task $task, Request $request)
    {
        foreach ($request->approvals as $approval) {
            if (isset($approval['id'])) {
                $task->approvals()->where('id', $approval['id'])->update($approval);
            } else {
                $task->approvals()->create($approval);
                $task->update(['status' => Task::STATUS_APPROVAL]);
            }
        }

        event(new ApprovalRequestEvent($task));
        return ['message' => "Approvals has been saved"];
    }

    public function deleteApproval(TaskApproval $taskApproval)
    {
        $taskApproval->delete();
        return ['message' => "Approval has been deleted"];
    }

    public function approve(Task $task, Request $request)
    {
        $this->authorize('approve', $task);

        $request->validate([
            'status' => 'required|boolean',
            'note' => 'required',
            'id' => 'required'
        ]);

        $approval = $task->approvals()
            ->where('id', $request->id)
            ->where('user_id', $request->user()->id)
            ->first();

        $approval->update($request->all());
        $pendingApproval = $task->approvals()->whereNull('status')->count();

        if ($pendingApproval > 0) {
            $task->update(['status' => Task::STATUS_PARTIALLY_APPROVED]);
        } else {
            $task->update(['status' => Task::STATUS_APPROVED]);
            event(new ApprovalCompletedEvent($task));
        }

        event(new TaskApprovedEvent($task, $request->user()));
        return ['message' => 'Task has been approved'];
    }

    public function comment(Task $task, Request $request)
    {
        $this->authorize('comment', $task);
        $request->validate(['body' => 'required']);

        $comment = $task->comments()
            ->create(array_merge(
                $request->all(),
                ['user_id' => $request->user()->id]
            ));

        if ($request->attachments) {
            $comment->attachments()->createMany($request->attachments);
        }

        event(new NewCommentEvent($comment));
        return ['message' => 'Comment has been saved',];
    }

    public function startExam(Task $task)
    {
        $this->authorize('startExam', $task);

        if ($task->exam->time_start == null) {
            $start = now();
            $task->exam->update(['time_start' => $start]);
        } else {
            $start = $task->exam->time_start;
        }

        $task->update(['status' => Task::STATUS_ON_PROGRESS]);

        return [
            'message' => 'Exam started',
            'time_start' => $start
        ];
    }

    public function finishExam(Task $task)
    {
        $this->authorize('finishExam', $task);

        $now = now();
        $task->exam->update(['time_finished' => $now]);
        $task->update(['status' => Task::STATUS_FINISHED]);
        event(new TaskFinishedEvent($task));

        return [
            'message' => 'Exam has been finished',
            'time_finished' => $now
        ];
    }

    public function submitExam(Task $task, Request $request)
    {
        $this->authorize('submitExam', $task);

        $request->validate([
            'index' => 'required|numeric',
            'answer' => 'required|in:0,1,2,3'
        ]);

        $userAnswer = $task->exam->quizzes;
        $userAnswer[$request->index]['user_answer'] = $request->answer;
        $task->exam->update(['quizzes' => $userAnswer]);

        return ['message' => 'Your answer has been saved'];
    }

    public function attest(Task $task)
    {
        $this->authorize('attest', $task);
        $task->update(['status' => Task::STATUS_FINISHED]);
        return ['message' => 'Data has been saved'];
    }

    public function getPendingApproval(Request $request)
    {
        $data = TaskApproval::whereNull('status')->where('user_id', $request->user()->id);

        return $request->count_only ? $data->count() : $data->get();
    }

    public function getNewTask(Request $request)
    {
        $data = Task::whereHas('assignees', function ($q) {
            $q->where('user_id', auth()->user()->id);
        })->where('status', Task::STATUS_SUBMITTED);

        return $request->count_only ? $data->count() : $data->get();
    }

    public function approvals(Task $task)
    {
        $this->authorize('view', $task);
        return $task->approvals;
    }

    public function comments(Task $task)
    {
        $this->authorize('view', $task);
        return $task->comments;
    }

    public function attachments(Task $task)
    {
        $this->authorize('view', $task);
        return $task->attachments;
    }

    public function exam(Task $task)
    {
        $this->authorize('view', $task);

        $open = [
            Task::STATUS_SUBMITTED,
            Task::STATUS_ON_PROGRESS,
            Task::STATUS_VOID
        ];

        if (in_array($task->status, $open) && $task->user_id != auth()->id()) {
            $quizzes = array_map(function ($quiz) {
                $quiz['correct_answer'] = null;
                return $quiz;
            }, $task->exam->quizzes);

            $exam = $task->exam;
            $exam->quizzes = $quizzes;
            return $exam;
        }

        return $task->exam;
    }

    public function document(Task $task)
    {
        $this->authorize('view', $task);
        return $task->document->load('versions');
    }

    public function statusList()
    {
        return Task::statusList();
    }

    public function typeList()
    {
        return Task::typeList();
    }

    public function priorityList()
    {
        return Task::priorityList();
    }
}
