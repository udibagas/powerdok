<template>
	<div style="min-width: 350px; border-left: 1px solid #ddd" class="p-3">
		<div class="text-muted mb-2">
			<i class="uil-user-check"></i>
			{{ $t("Assigned to") }}
		</div>
		<div class="media">
			<el-avatar icon="el-icon-user" class="mr-3"></el-avatar>
			<div class="media-body">
				<strong>{{
					task.assignee_id == $auth.user.id ? $t("Me") : task.user.name
				}}</strong>
				<div class="text-muted">
					{{ task.assignee.position }} |
					{{ task.assignee.department ? task.assignee.department.name : "N/A" }}
				</div>
			</div>
		</div>

		<div class="text-muted mt-4 mb-2">
			{{ $t("Task No.") }}
		</div>
		<h5>#{{ task.id }}</h5>

		<div class="text-muted mt-4 mb-2">
			{{ $t("Task Type") }}
		</div>
		<h5>{{ task.type_name }}</h5>

		<div class="text-muted mt-4 mb-2">
			{{ $t("Priority") }}
		</div>
		<h5>{{ task.priority_label }}</h5>

		<div class="text-muted mt-4 mb-2">
			{{ $t("Status") }}
		</div>
		<h5>{{ task.status_label }}</h5>

		<div class="text-muted mt-4 mb-2">
			{{ $t("Due Date") }}
		</div>
		<h5>
			{{ task.due_date ? $moment(task.due_date).format("DD-MMM-YYYY") : "N/A" }}
		</h5>
	</div>
</template>

<script>
export default {
	props: ["task"]
};
</script>
