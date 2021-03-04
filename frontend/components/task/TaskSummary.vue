<template>
	<div>
    <div class="row">
      <div class="col">
        <div>
          <div class="text-muted">
            {{ $t("Task No.") }}
          </div>
          <h4>#{{ task.id }}</h4>
        </div>
      </div>

      <div class="col">
        <div>
          <div class="text-muted">
            {{ $t("Status") }}
          </div>
          <h4>{{ task.status_label }}</h4>
        </div>
      </div>

      <div class="col">
        <div class="text-muted">
          {{ $t("Due Date") }}
        </div>
        <h4>
          {{
            task.due_date ? $moment(task.due_date).format("DD-MMM-YYYY") : "N/A"
          }}
        </h4>
      </div>
    </div>

    <hr>

    <div class="row">
      <div class="col">
        <div class="text-muted">
          {{ $t("Creator") }}
        </div>
        <div class="media mt-3">
          <el-avatar class="mr-3"></el-avatar>
          <div class="media-body">
            <strong>{{ task.user.name }}</strong>
            <span class="text-muted">
              &bull; {{ $moment(task.created_at).fromNow() }}
            </span>
            <div class="text-muted">
              {{ task.user.position }} |
              {{ task.user.department ? task.user.department.name : "N/A" }}
            </div>
          </div>
        </div>
      </div>

      <div class="col">
        <div class="text-muted">
          {{ $t("Assignees") }}
        </div>
        <div class="media mt-3">
          <el-avatar class="mr-3"></el-avatar>
          <div class="media-body">
            <strong>{{ task.assignee.name }}</strong>
            <div class="text-muted">
              {{ task.assignee.position }} |
              {{
                task.assignee.department ? task.assignee.department.name : "N/A"
              }}
            </div>
          </div>
        </div>
      </div>
    </div>
	</div>
</template>

<script>
export default {
  props: ['task']
}
</script>

<style>
</style>
