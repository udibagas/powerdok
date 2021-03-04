<template>
	<div style="width: 300px">
		<div class="text-muted">
			{{ $t("Task No.") }}
		</div>
		<h4>#{{ task.id }}</h4>

		<div class="text-muted mt-3">
			{{ $t("Priority") }}
		</div>
		<h4>{{ task.priority_label }}</h4>

		<div class="text-muted mt-3">
			{{ $t("Status") }}
		</div>
		<h4>{{ task.status_label }}</h4>

		<div class="text-muted mt-3">
			{{ $t("Due Date") }}
		</div>
		<h4>
			{{ task.due_date ? $moment(task.due_date).format("DD-MMM-YYYY") : "N/A" }}
		</h4>

		<div class="text-muted mt-3">
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

		<div class="text-muted mt-3">
			{{ $t("Assignees") }}
		</div>
		<div class="media mt-3">
			<el-avatar class="mr-3"></el-avatar>
			<div class="media-body">
				<strong>{{ task.assignee.name }}</strong>
				<div class="text-muted">
					{{ task.assignee.position }} |
					{{ task.assignee.department ? task.assignee.department.name : "N/A" }}
				</div>
			</div>
		</div>

		<div class="text-muted mt-3">
			{{ $t("Related Document") }}
		</div>
		<div class="mt-3">
			<strong>{{ task.document.type_name }}</strong> &nbsp; No.
			{{ task.document.number }} &nbsp; Ver. {{ task.document.version }}
		</div>
		<nuxt-link :to="`/documents/${task.document.slug}`" style="font-size: 18px">
			{{ task.document.title }}
		</nuxt-link>
	</div>
</template>

<script>
export default {
	props: ["task"]
};
</script>
