<template>
	<div class="d-flex justify-content-between px-5">
		<div>
			<div>
				<div class="text-muted">
					{{ $t("Task No.") }}
				</div>
				<h4 class="mt-3">#{{ task.id }}</h4>
			</div>
		</div>

		<div>
			<div>
				<div class="text-muted">
					{{ $t("Status") }}
				</div>
				<el-tag class="mt-3" effect="dark">{{ task.status_label }}</el-tag>
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
			<div class="media mt-3" v-for="user in task.assignees" :key="user.id">
				<el-avatar class="mr-3"></el-avatar>
				<div class="media-body">
					<strong>{{ user.name }}</strong>
					<div class="text-muted">
						{{ user.position }} |
						{{ user.department ? user.department.name : "N/A" }}
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
