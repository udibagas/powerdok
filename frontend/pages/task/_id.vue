<template>
	<div>
		<div class="border rounded shadow bg-white d-flex">
			<div class="flex-grow-1 p-3">
				<!-- <div class="text-info mt-3" style="font-size: 1.2rem">
					<i class="el-icon-collection-tag"></i>
					{{ task.type_name }}
				</div> -->
				<h3 class="mt-3 mb-0">
					<span class="text-muted"> #{{ task.id }} </span>
					{{ task.title }}
				</h3>

				<div class="row mt-4 p-3 rounded border-top border-bottom">
					<div class="col-md-3">
						<div class="text-muted mb-1">
							{{ $t("Type") }}
						</div>
						<h5 class="text-info">{{ task.type_name }}</h5>
					</div>

					<div class="col-md-3">
						<div class="text-muted mb-1">
							{{ $t("Priority") }}
						</div>
						<h5 :class="`text-${priorityColors[task.priority_label]}`">
							{{ task.priority_label }}
						</h5>
					</div>

					<div class="col-md-3">
						<div class="text-muted mb-1">
							{{ $t("Status") }}
						</div>
						<h5 :class="`text-${statusColors[task.status_label]}`">
							{{ task.status_label }}
						</h5>
					</div>

					<div class="col-md-3">
						<div class="text-muted mb-1">
							{{ $t("Due Date") }}
						</div>
						<h5 class="text-danger">
							{{
								task.due_date
									? $moment(task.due_date).format("DD-MMM-YYYY")
									: "N/A"
							}}
						</h5>
					</div>
				</div>

				<div class="media my-4">
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
					</div>
				</div>

				<div>
					<div class="mb-4 text-justify" v-html="task.description"></div>

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

					<Attachments class="mt-5" :url="`/api/task/attachments/${task.id}`" />
				</div>
			</div>

			<TaskSummary style="min-width: 300px" :task="task" />
		</div>

		<TaskApproval
			v-if="
				task.type == TASK_TYPE.DOCUMENT_REVIEW &&
				![TASK_STATUS.NEW, TASK_STATUS.ON_PROGRESS].includes(task.status)
			"
			:task="task"
			@refresh="fetchData"
		/>

		<DocumentForm
			class="mt-3"
			v-if="task.type == TASK_TYPE.DOCUMENT_REVIEW"
			:task="task"
			@refresh="fetchData"
		/>

		<Atestation
			class="mt-3"
			:task="task"
			v-if="task.type == TASK_TYPE.ATESTATION"
			@refresh="fetchData"
		/>

		<TaskExam
			class="mt-3"
			v-if="task.type == TASK_TYPE.EXAMINATION"
			:task="task"
			@refresh="fetchData"
		/>

		<Comments
			:allowComment="
				![TASK_STATUS.CLOSED, TASK_STATUS.VOID].includes(task.status)
			"
			:url="`/api/task/comments/${task.id}`"
		/>
	</div>
</template>

<script>
import { TASK_STATUS, TASK_TYPE } from "@/store/modules/task";
import { mapState } from "vuex";

export default {
	data() {
		return {
			document: "",
			TASK_TYPE,
			TASK_STATUS
		};
	},

	computed: {
		...mapState(["priorityColors", "statusColors", "statusList"])
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
