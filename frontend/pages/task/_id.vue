<template>
	<div>
		<el-card>
			<TaskSummary slot="header" :task="task" />
			<div class="row px-3">
				<div class="col">
          <div class="text-muted">
            {{ $t("Task Title") }}
          </div>
          <div class="mt-3">
            <h4>{{ task.title }}</h4>
          </div>
          <div class="text-muted text-justify mt-3">
            {{ task.description }}
          </div>
				</div>
        <div class="col">
          <div class="text-muted">
            {{ $t("Related Document") }}
          </div>
          <div class="mt-3">
            <strong>{{ task.document.type_name }}</strong> &nbsp; No. {{ task.document.number }} &nbsp; Ver. {{ task.document.version }}
          </div>
          <nuxt-link :to="`/documents/${task.document.slug}`" style="font-size: 18px">
            {{ task.document.title }}
          </nuxt-link>
				</div>
			</div>
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
import { TASK_STATUS, TASK_TYPE } from '@/store/modules/task'

export default {
  components: {
    ckeditor: CKEditor.component
  },

  data() {
    return {
      document: '',
      editor: ClassicEditor,
      TASK_TYPE,
      TASK_STATUS
    }
  },

  async asyncData({$axios, params}) {
    const task = await $axios.$get(`/api/task/${params.id}`);
    return { task };
  },

  head() {
    return {
      title: `Powerdok | Task - ${this.task.title}`,
    };
  },

  methods: {
    async fetchData() {
      this.task = await this.$axios.$get(`/api/task/${this.task.id}`);
    }
  }
}
</script>

<style>
</style>
