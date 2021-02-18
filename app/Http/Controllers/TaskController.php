<?php

namespace App\Http\Controllers;

use App\Events\NewCommentEvent;
use App\Events\NewTaskEvent;
use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskCollection;
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
            Task::with('assignees')->when($request->keyword, function ($q) use ($request) {
                $q->where(function ($q) use ($request) {
                    $q->where('title', 'ILIKE', "%{$request->keyword}%")
                        ->orWhere('description', 'ILIKE', "%{$request->keyword}%")
                        ->orWhereHas('assignees', function ($q) use ($request) {
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
        $task = DB::transaction(function () use ($request) {
            $task = Task::create(array_merge($request->all(), ['user_id' => $request->user()->id]));

            if ($task->assignees) {
                $task->assignees()->createMany($request->assignees);
            }

            if ($request->attachments) {
                $task->attachments()->createMany($request->attachments);
            }

            return $task;
        });

        event(new NewTaskEvent($task));
        return ['message' => 'Data has been saved', 'data' => $task];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        // $this->authorize('view', $task);

        return $task->load([
            'assignees',
            'attachments',
            // 'document',
            'comments',
            'approvals',
            'trackings'
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
        $task->update($request->all());

        if ($request->attachments) {
            $task->attachments()->delete();
            $task->attachments()->createMany($request->attachments);
        }

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
        $task->delete();
        return ['message' => 'Data has been deleted'];
    }

    public function approve(Task $task, Request $request)
    {
        $this->authorize('approve', $task);
        $request->validate(['status' => 'required|boolean']);

        $task->approvals()
            ->where('user_id', $request->user()->id)
            ->update($request->all());

        return ['message' => 'Approval has been saved'];
    }

    public function comment(Task $task, Request $request)
    {
        $this->authorize('comment', $task);
        $request->validate(['body' => 'required']);
        $comment = $task->comments()->create($request->all());

        if ($request->attachments) {
            $comment->attachments()->createMany($request->attachments);
        }

        event(new NewCommentEvent($comment));
        return ['message' => 'Comment has been saved'];
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
}
