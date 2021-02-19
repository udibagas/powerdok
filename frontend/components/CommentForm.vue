<template>
	<div class="media my-3 pt-3">
		<el-avatar class="mr-3"></el-avatar>
		<div class="media-body">
			<el-form>
				<el-form-item>
					<el-input
						v-model="form.body"
						type="textarea"
						rows="5"
						placeholder="Type your comment here"
					></el-input>
				</el-form-item>
			</el-form>

			<div class="text-right">
				<el-button class="btn-primary" @click="save">
					<i class="uil-comment-dots mr-1"></i> {{ $t("COMMENT") }}
				</el-button>
				<!-- <el-button class="btn-success" icon="el-icon-check">
						APPROVE
					</el-button>
					<el-button class="btn-danger" icon="el-icon-close">
						DECLINE
					</el-button> -->
			</div>
		</div>
	</div>
</template>

<script>
export default {
  props: ['task'],

  data() {
    return {
      form: {},
      errors: {}
    }
  },

  methods: {
    save() {
      this.$axios.$post(`/api/task/comment/${this.task.id}`, this.form).then(response => {
        this.$message({
          message: response.message,
          type: 'success',
          showClose: true
        });

        this.form = {};
        this.errors = {};
        this.$emit('refresh', response.task);
      }).catch(e => {
        if (e.response.status == 422) {
          this.errors = e.response.data.errors;
        }

        this.$message({
          message: e.response.data.message,
          type: 'error',
          showClose: true
        });
      })
    },
  }
}
</script>

<style>
</style>
