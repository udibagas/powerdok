<template>
	<div>
		<el-card class="mb-3" v-if="task.status == TASK_STATUS.FINISHED">
			<div class="d-flex justify-content-between">
				<h1>
					{{ $t("SCORE") }}: {{ task.exam.score }}%
					<small>
						({{ task.exam.correct_answer }}/{{ task.exam.quizzes.length }})
					</small>
				</h1>
				<h1
					:class="{
						'text-success': task.exam.passed,
						'text-danger': !task.exam.passed,
					}"
				>
					{{ task.exam.passed ? $t("PASSED") : $t("FAILED") }}
				</h1>
			</div>
		</el-card>

		<el-card header="Quiz">
			<div
				v-for="(e, index) in task.exam.quizzes"
				:key="index"
				class="d-flex mb-4 border p-3 rounded"
				:class="{
					'border-success':
						e.correct_answer == e.user_answer &&
						task.status == TASK_STATUS.FINISHED,
					'border-danger':
						e.correct_answer != e.user_answer &&
						task.status == TASK_STATUS.FINISHED,
				}"
			>
				<div class="mr-3">
					<h4 class="text-muted">#{{ index + 1 }}</h4>
				</div>
				<div class="flex-grow-1">
					<div class="d-flex">
						<div class="mr-3 mb-3 flex-grow-1">
							{{ e.question }}

							<div class="d-flex flex-wrap">
								<el-image
									class="mb-3 border mr-3 rounded"
									style="height: 250px"
									v-for="(url, j) in e.attachments"
									:src="url"
									:key="j"
								></el-image>
							</div>
						</div>
					</div>

					<div class="row">
						<div v-for="(c, i) in e.choices" :key="i" class="col-5 mb-3 d-flex">
							<el-radio
								v-model="e.user_answer"
								:label="i"
								:disabled="task.status == TASK_STATUS.FINISHED"
							>
								<span
									:class="{
										'bg-success p-1 rounded text-white': e.correct_answer == i,
										'bg-danger text-white p-1 rounded':
											i == e.user_answer && e.user_answer != e.correct_answer,
									}"
								>
									<strong class="text-muted" style="display: inline-block">
										{{ ["A", "B", "C", "D"][i] }}.
									</strong>
									{{ e.choices[i] }}
								</span>
							</el-radio>
						</div>
					</div>
				</div>
			</div>

			<div class="text-right" v-if="task.status != TASK_STATUS.FINISHED">
				<el-button size="small" @click="submitExam(0)">
					SAVE AS DRAFT
				</el-button>

				<el-button size="small" type="primary" @click="confirmSubmit(1)">
					SUBMIT
				</el-button>
			</div>
		</el-card>
	</div>
</template>

<script>
export default {
  props: ['task'],

  computed: {
    ...mapState(['TASK_STATUS'])
  },

  methods: {
    submitExam(status) {
      const answer = this.task.exam.quizzes.map(q => q.user_answer);
      this.$axios.$post(`/api/task/submitExam/${this.task.id}`, { answer, status }).then(response => {
        this.$message({
          message: response.message,
          type: 'success',
          showClose: true
        })
      }).catch(e => {
        this.$message({
          message: e.response.data.message,
          type: 'error',
          showClose: true
        });

        if (e.response.status == 422) {
          this.errors = e.response.data.errors
        }
      })
    },

    confirmSubmit() {
      this.$confirm('Are you sure want to submit your answer ?', 'Confirm').then(() => this.submitExam(status))
    }
  }
}
</script>

<style>
</style>
