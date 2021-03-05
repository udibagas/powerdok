<template>
  <div class="row">
    <div class="col-md-3">
      <div class="text-muted mb-1">
        {{ $t("Task No.") }}
      </div>
      <h5>#{{ task.id }}</h5>
    </div>

    <div class="col-md-3">
      <div class="text-muted mb-1">
        {{ $t("Priority") }}
      </div>
      <h5>{{ task.priority_label }}</h5>
    </div>

    <div class="col-md-3">
      <div class="text-muted mb-1">
        {{ $t("Status") }}
      </div>
      <h5>{{ task.status_label }}</h5>
    </div>

    <div class="col-md-3">
      <div class="text-muted mb-1">
        {{ $t("Due Date") }}
      </div>
      <h5>
        {{ task.due_date ? $moment(task.due_date).format("DD-MMM-YYYY") : "N/A" }}
      </h5>
    </div>
  </div>
</template>

<script>
export default {
	props: ["task"]
};
</script>
