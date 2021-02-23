<template>
	<div>
		<el-card>
			<TaskSummary slot="header" :task="task" />
			<div class="media">
				<el-avatar class="mr-3"></el-avatar>
				<div class="media-body">
					<strong>{{ task.user.name }}</strong>
					<span class="text-muted">
						&bull; {{ $moment(task.created_at).fromNow() }}</span
					>
					<div class="text-muted">
						{{ task.user.position }} |
						{{ task.user.department ? task.user.department.name : "N/A" }}
					</div>

					<h5 class="mt-3">{{ task.title }}</h5>

					<div class="mt-3">{{ task.description }}</div>
				</div>
			</div>
		</el-card>

		<div class="mt-3">
			<ckeditor v-model="document" :editor="editor"></ckeditor>
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

export default {
  components: {
    ckeditor: CKEditor.component
  },

  data() {
    return {
      document: '',
      editor: ClassicEditor
    }
  },

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
    async fetchData() {
      this.task = await this.$axios.$get(`/api/task/${this.task.id}`);
    }
  }
}
</script>

<style>
</style>
