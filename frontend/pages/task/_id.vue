<template>
	<div>
		<div class="border rounded shadow bg-white d-flex">
			<div class="flex-grow-1 p-3">
				<div class="media">
					<el-avatar class="mr-3" :size="45" icon="el-icon-user"></el-avatar>
					<div class="media-body">
						<strong>{{ task.user.name }}</strong>

						<span class="text-muted">
							&bull;
							{{ task.user.position }} |
							{{ task.user.department ? task.user.department.name : "N/A" }}
							<br />
							<i>
								{{ $moment(task.created_at).lang($i18n.locale).fromNow() }}
							</i>
						</span>

						<div class="row mt-4 bg-light p-3 rounded">
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
									{{
										task.due_date
											? $moment(task.due_date).format("DD-MMM-YYYY")
											: "N/A"
									}}
								</h5>
							</div>
						</div>

						<h3 class="my-4">{{ task.title }}</h3>

						<div class="mb-4 pr-3 text-justify" v-html="task.description"></div>

						<div v-if="task.document" class="mt-5">
							<div class="text-muted mb-3">
								<i class="el-icon-paperclip"></i>
								{{ $t("Related Document") }}
							</div>
							<div class="media">
								<i class="el-icon-document mr-2" style="font-size: 40px"></i>
								<div class="media-body">
									<div>
										<strong>{{ task.document.type_name }}</strong> &nbsp; No.
										{{ task.document.latest_version.number }} &nbsp; Ver.
										{{ task.document.latest_version.version }}
									</div>
									<nuxt-link :to="`/documents/${task.document.id}`">
										{{ task.document.title }}
									</nuxt-link>
								</div>
							</div>
						</div>

						<Attachments
							class="mt-5"
							:url="`/api/task/attachments/${task.id}`"
						/>
					</div>
				</div>
			</div>

			<TaskSummary :task="task" />
		</div>

		<TaskApproval
			v-if="task.type == TASK_TYPE.DOCUMENT_REVIEW"
			:task="task"
			@refresh="fetchData"
		/>

		<div class="mt-3">
			<DocumentForm
				v-if="task.type == TASK_TYPE.DOCUMENT_REVIEW"
				:task="task"
				@refresh="fetchData"
			/>
			<TaskExam
				v-if="task.type == TASK_TYPE.EXAMINATION"
				:task="task"
				@refresh="fetchData"
			/>
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
