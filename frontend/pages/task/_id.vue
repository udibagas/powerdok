<template>
	<div>
		<div class="border rounded shadow bg-white p-3 d-flex">
			<div class="flex-grow-1">
				<h2>{{ task.title }}</h2>

				<div class="my-4 text-muted">
					{{ task.description }}
				</div>

				<div v-if="task.document">
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

				<Attachments class="mt-3" :url="`/api/task/attachments/${task.id}`" />
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
