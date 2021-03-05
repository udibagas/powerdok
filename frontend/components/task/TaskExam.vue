<template>
	<div>
    <el-card v-if="!start" class="mb-3 text-center" shadow="hover">
      <a href="#" @click.prevent="confirmStart">
        <h3> START EXAM</h3>
      </a>
    </el-card>
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

    <div v-if="start">
      <el-card
        v-for="(e, index) in task.exam.quizzes"
        class="mb-2"
        :key="index"
        :class="{
          'border-success':
            e.correct_answer == e.user_answer &&
            task.status == TASK_STATUS.FINISHED,
          'border-danger':
            e.correct_answer != e.user_answer &&
            task.status == TASK_STATUS.FINISHED,
        }"
      >
        <div class="d-flex">
          <div class="mr-3">
            <h4 class="text-muted">#{{ index + 1 }}</h4>
            <i class="el-icon-circle-check text-success" style="font-size:30px"></i>
            <i class="el-icon-circle-close text-danger" style="font-size:30px"></i>
          </div>
          <div class="flex-grow-1">
            <div class="d-flex">
              <div class="mr-3 mb-3 flex-grow-1">
                {{ e.question }}

                <div class="d-flex flex-wrap" v-for="(url, i) in e.attachments" :key="i">
                  <a href="#" @click.prevent="index = i; visible = true">
                    <el-image
                      class="my-3 border mr-3 rounded"
                      style="height: 100px;width:100px"
                      :src="url"
                    ></el-image>
                  </a>
                </div>
                <vue-easy-lightbox
                  :visible="visible"
                  :imgs="e.attachments"
                  :index="index"
                  @hide="visible = false"
                ></vue-easy-lightbox>
              </div>
            </div>

            <div class="row">
              <div v-for="(c, i) in e.choices" :key="i" class="col-5 mb-3 d-flex">
                <el-radio
                  v-model="e.user_answer"
                  :label="i"
                  :disabled="!allowSubmitTask"
                >
                  <strong class="text-muted" style="display: inline-block">
                    {{ ["A", "B", "C", "D"][i] }}.
                  </strong>
                  {{ e.choices[i] }}
                </el-radio>
              </div>
            </div>
          </div>
        </div>
      </el-card>

      <el-card  v-if="allowSubmitTask">
        <div class="d-flex justify-content-between">
          <div>
            <el-button icon="el-icon-back" size="small" type="danger">
              BACK
            </el-button>
          </div>
          <div>
            <el-button size="small" type="primary">
              NEXT <i class="el-icon-right ml-1"></i>
            </el-button>
            <el-button icon="el-icon-finished" size="small" type="success" @click="confirmSubmit(1)">
              SUBMIT
            </el-button>
          </div>
        </div>
      </el-card>
    </div>
	</div>
</template>

<script>
import { TASK_STATUS, TASK_TYPE } from '@/store/modules/task'

export default {
  props: ['task'],

  data() {
    return {
      TASK_TYPE,
      TASK_STATUS,
      visible: false,
      index: 0,
      start: false,
      time_start: null,
      time_finished: null
    }
  },

  computed: {
    allowSubmitTask() {
      return this.task.assignee_id == this.$auth.user.id &&
        [TASK_STATUS.SUBMITTED, TASK_STATUS.ON_PROGRESS].includes(this.task.status);
    },
  },

  methods: {
    confirmStart() {
      // TODO
      this.start = true;
      this.time_start = new Date();
    },

    submitExam() {
      this.time_finished = new Date();
      const answer = this.task.exam.quizzes.map(q => q.user_answer);
      this.$axios.$post(`/api/task/submitExam/${this.task.id}`, { answer }).then(response => {
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
