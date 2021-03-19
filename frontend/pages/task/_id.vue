<template>
	<div>
		<el-card>
			<TaskSummary slot="header" :task="task" />
			<div class="row mr-2">
				<div class="col text-justify">
					<h2>{{ task.title }}</h2>

          <div class="mt-2 text-muted text-justify">
            {{ task.description }}
          </div>
        </div>
      </div>
      <div class="row mt-4">
        <div class="col" v-if="task.document">
          <div class="text-muted">
            <i class="el-icon-document"></i>
            {{ $t("Related Document") }}
          </div>
          <div class="mt-1">
            <strong>{{ task.document.type_name }}</strong> &nbsp; No.
            {{ task.document.latest_version.number }} &nbsp; Ver. {{ task.document.latest_version.version }}
          </div>
          <nuxt-link :to="`/documents/${task.document.id}`" style="font-size: 16px">
            {{ task.document.title }}
          </nuxt-link>
        </div>
        <div class="col">
          <div class="text-muted">
            <i class="uil-user-check"></i>
            {{ $t("Assigned to") }}
          </div>
          <div class="media mt-1">
            <el-avatar class="mr-3"></el-avatar>
            <div class="media-body">
              <strong>{{ task.assignee_id == $auth.user.id ? "Me" : task.user.name }}</strong>
              <div class="text-muted">
                {{ task.assignee.position }} |
                {{ task.assignee.department ? task.assignee.department.name : "N/A" }}
              </div>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="text-muted">
            <i class="uil-user"></i>
            {{ $t("Creator") }}
          </div>
          <div class="media mt-1">
            <el-avatar class="mr-3"></el-avatar>
            <div class="media-body">
              <strong>{{ task.assignee_id == $auth.user.id ? "Me" : task.user.name }}</strong>
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
      </div>
      <hr>
      <!-- <Attachments :attachments="task.attachments" /> -->
		</el-card>

		<TaskApproval
      v-if="task.status != TASK_STATUS.SUBMITTED && task.status != TASK_STATUS.ON_PROGRESS"
      :task="task"
      @refresh="fetchData"
    />

		<div class="mt-3">
			<DocumentForm
				v-if="task.type == TASK_TYPE.DOCUMENT_REVIEW"
				:task="task"
				@refresh="fetchData"
			/>
			<TaskExam v-if="task.type == TASK_TYPE.EXAMINATION" :task="task" />
		</div>

		<Comments :url="`/api/task/comments/${task.id}`" />
	</div>
</template>

<script>
import { TASK_STATUS, TASK_TYPE } from "@/store/modules/task";

export default {
	data() {
		return {
			document: "",
			TASK_TYPE,
			TASK_STATUS
		};
	},

	async asyncData({ $axios, params }) {
		const task = await $axios.$get(`/api/task/${params.id}`);
		return { task };
	},

	head() {
		return {
			title: `Powerdok | Task - ${this.task.title}`
		};
	},

	methods: {
		async fetchData() {
			this.task = await this.$axios.$get(`/api/task/${this.task.id}`);
		}
	}
};
</script>
