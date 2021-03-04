<template>
	<div>
    <div class="row">
      <div class="col-md-1">
        <div class="text-muted">
          {{ $t("Task No.") }}
        </div>
        <div class="mt-1">
          <h6>#{{ task.id }}</h6>
        </div>
      </div>
      <div class="col-md-1">
        <div class="text-muted">
          {{ $t("Status") }}
        </div>
        <div class="mt-1">
          <h6>{{ task.status_label }}</h6>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col mt-2">
        <h4>{{ task.title }}</h4>
        <div class="text-muted text-justify mt-2">
          {{ task.description }}
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
        <div class="text-muted">
          {{ $t("Related Document") }}
        </div>
        <div class="mt-1">
          <strong>{{ task.document.type_name }}</strong> &nbsp; No. {{ task.document.number }} &nbsp; Ver. {{ task.document.version }}
        </div>
        <nuxt-link :to="`/documents/${task.document.slug}`" style="font-size: 18px">
          {{ task.document.title }}
        </nuxt-link>
      </div>
    </div>

    <hr>

    <div class="row">
      <div class="col">
        <div class="text-muted">
          {{ $t("Creator") }}
        </div>
        <div class="media mt-1">
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
