<template>
	<div class="d-flex justify-content-between px-3 flex-wrap">
		<div>
			<div>
				<div class="text-muted">
					{{ $t("Task No.") }}
				</div>
				<h3 class="mt-3">#{{ task.id }}</h3>
			</div>
		</div>

		<div>
			<div>
				<div class="text-muted">
					{{ $t("Status") }}
				</div>
				<h4 class="mt-3">{{ task.status_label }}</h4>
			</div>
		</div>

		<div>
			<div class="text-muted">
				{{ $t("Due Date") }}
			</div>
			<h4 class="mt-3">
				{{
					task.due_date ? $moment(task.due_date).format("DD-MMM-YYYY") : "N/A"
				}}
			</h4>
		</div>

		<div>
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

		<div>
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
</template>

<script>
export default {
  props: ['task']
}
</script>

<style>
</style>
