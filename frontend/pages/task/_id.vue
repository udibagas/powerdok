<template>
	<el-row :gutter="20">
		<el-col :span="16">
			<el-card>
				<div class="media">
					<el-avatar class="mr-3"></el-avatar>
					<div class="media-body">
						<div class="d-flex justify-content-between">
							<div>
								<strong>{{ task.user.name }}</strong>
								<div class="text-muted">
									{{ task.user.position }} |
									{{ task.user.department ? task.user.department.name : "N/A" }}
								</div>
							</div>
							<small class="text-muted">
								{{ readableDateTime(task.created_at) }}
							</small>
						</div>

						<h5 class="mt-3">{{ task.title }}</h5>

						<div class="mt-3">{{ task.description }}</div>
					</div>
				</div>

				<CommentForm :task="task" @refresh="(new_task) => (task = new_task)" />

				<Comments :comments="task.comments" />
			</el-card>
		</el-col>
		<el-col :span="8">
			<el-card>
				<div slot="header">#{{ task.id }}</div>

				<div class="text-primary">
					{{ $t("Status") }}
				</div>
				<el-tag class="mt-3" effect="dark">{{ task.status_label }}</el-tag>

				<div class="text-primary mt-5 mb-2">
					{{ $t("Due Date") }}
				</div>
				<h4>{{ task.due_date ? readableDate(task.due_date) : "N/A" }}</h4>

				<div class="text-primary mt-5">
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

				<div class="text-primary mt-5">
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
			</el-card>
		</el-col>
	</el-row>
</template>

<script>
import moment from 'moment';

export default {
  async asyncData({$axios, params}) {
    const task = await $axios.$get(`/api/task/${params.id}`);
    return { task };
  },

  head() {
    return {
      title: `Powerdok | Task : ${this.task.title}`,
    };
  },

  methods: {
    readableDate(date) {
      return moment(date).format('DD-MMM-YYYY');
    },

    readableDateTime(date) {
      return moment(date).format('DD-MMM-YYYY HH:mm');
    }
  }
}
</script>

<style>
</style>
