<template>
	<div style="min-width: 400px; border-left: 1px solid #ddd" class="p-3">
		<!-- <div class="text-muted mb-2">
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
		</div> -->

		<br />

		<el-timeline>
			<el-timeline-item
				v-for="track in trackings"
				:key="track.id"
				type="primary"
				:timestamp="$moment(track.created_at).format('DD-MMM-YYYY HH:mm')"
				placement="top"
			>
				<div class="media">
					<el-avatar icon="el-icon-user" class="mr-3"></el-avatar>
					<div class="media-body">
						<strong>{{
							track.user_id == $auth.user.id ? $t("Me") : track.user.name
						}}</strong>
						<div class="text-muted">
							{{ track.user.position }} |
							{{ track.user.department ? track.user.department.name : "N/A" }}
						</div>
						<el-tag class="my-3" effect="dark">{{ track.status_label }}</el-tag>
					</div>
				</div>
			</el-timeline-item>
		</el-timeline>
	</div>
</template>

<script>
export default {
	props: ["task"],

	watch: {
		"task.updated_at"(v) {
			this.getTracking();
		}
	},

	data() {
		return {
			trackings: []
		};
	},

	methods: {
		getTracking() {
			this.$axios.$get(`/api/task/trackings/${this.task.id}`).then(response => {
				this.trackings = response;
			});
		}
	},

	mounted() {
		this.getTracking();
	}
};
</script>
