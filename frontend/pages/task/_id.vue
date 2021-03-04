<template>
	<div>
		<el-card class="d-flex">
			<div class="flex-grow-1 mr-3">
				<h4>{{ task.title }}</h4>

				<div class="text-muted text-justify mt-3">
					{{ task.description }}
				</div>
			</div>

			<TaskSummary :task="task" />
		</el-card>

		<div class="mt-3">
			<ckeditor
				v-if="task.type == TASK_TYPE.DOCUMENT_REVIEW"
				v-model="document"
				:editor="editor"
			></ckeditor>
			<TaskExam v-if="task.type == TASK_TYPE.EXAMINATION" :task="task" />
		</div>

		<el-card :header="$t('SUBMIT COMMENT')" class="mt-3">
			<CommentForm :task="task" @refresh="fetchData" />
		</el-card>

		<el-card :header="$t('Comments')" class="my-3">
			<Comments :comments="task.comments" />
		</el-card>
	</div>
</template>

<script>
import CKEditor from "@ckeditor/ckeditor5-vue";
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
import { TASK_STATUS, TASK_TYPE } from "@/store/modules/task";

export default {
	components: {
		ckeditor: CKEditor.component
	},

	data() {
		return {
			document: "",
			editor: ClassicEditor,
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
