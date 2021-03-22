<template>
	<div style="width: 300px; border-left: 1px solid #ddd" class="p-3">
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

		<!-- TODO : Tracking -->
	</div>
</template>

<script>
export default {
	props: ["task"]
};
</script>
