<template>
  <el-dialog fullscreen :visible="show" :show-close="false">
    <el-card>
      <div class="d-flex justify-content-between">
        <div>
          <div class="text-muted">Minimum Score</div>
          <h4>{{ task.exam.exam_minimum_score }}</h4>
        </div>

        <div class="text-center">
          <h1>{{timer}}</h1>
        </div>
        <div>
          <div class="text-muted">Duration</div>
          <h4> {{ task.exam.exam_max_duration || '0' }} {{$t('minutes')}}</h4>
        </div>
      </div>
    </el-card>
    <div class="d-flex p-3 mt-3 border rounded shadow" style="height: 400px">
      <h4 style="width:60px" class="text-muted">#{{ index + 1 }}</h4>
      <div class="flex-grow-1">
        <div class="d-flex">
          <div class="mr-3 mb-3 flex-grow-1">
            <h4>{{ task.exam.quizzes[index].question }}</h4>

            <div class="row my-3">
              <div class="col-md-2" v-for="(url, i) in task.exam.quizzes[index].attachments" :key="i">
                <a href="#">
                  <el-image
                    class="my-2 border rounded"
                    style="height: 150px;width:150px"
                    :src="url"
                  ></el-image>
                </a>
              </div>
            </div>
            <!-- <vue-easy-lightbox
              :visible="visible"
              :imgs="task.exam.quizzes[index].attachments"
              :index="index"
              @hide="visible = false"
            ></vue-easy-lightbox> -->
          </div>
        </div>

        <div class="row">
          <div v-for="(c, i) in task.exam.quizzes[index].choices" :key="i" class="col-5 mb-3 d-flex">
            <el-radio
              v-model="task.exam.quizzes[index].user_answer"
              :label="i"
              :disabled="!allowSubmitTask"
            >
              <strong class="text-muted" style="display: inline-block">
                {{ ["A", "B", "C", "D"][i] }}.
              </strong>
              {{ task.exam.quizzes[index].choices[i] }}
            </el-radio>
          </div>
        </div>
      </div>
    </div>

    <div class="d-flex justify-content-between" slot="footer">
      <div>
        <el-button v-if="index > 0" icon="el-icon-back" size="small" type="danger" @click="prevQuiz">
          BACK
        </el-button>
      </div>
      <div class="text-center">
        <h3>
        <el-input style="width:70px" v-model="page"></el-input>/{{task.exam.quizzes.length}}
        </h3>
      </div>
      <div>
        <el-button v-if="index != lastIndex" size="small" type="primary" @click="nextQuiz">
          NEXT <i class="el-icon-right ml-1"></i>
        </el-button>
        <el-button v-if="index == lastIndex" icon="el-icon-finished" size="small" type="success" @click="confirmSubmit">
          SUBMIT
        </el-button>
      </div>
    </div>
  </el-dialog>
</template>

<script>
import { TASK_STATUS, TASK_TYPE } from '@/store/modules/task'
import moment from 'moment';

export default {
  props: ['task', 'show'],

  watch: {
    page(v) {
      if (v > 0 && v <= this.task.exam.quizzes.length) {
        this.index = v - 1;
      }
    }
  },

  mounted() {
    this.runTimer();
  },

  computed: {
    allowSubmitTask() {
      return this.task.assignee_id == this.$auth.user.id &&
        [TASK_STATUS.SUBMITTED, TASK_STATUS.ON_PROGRESS].includes(this.task.status);
    },

    lastIndex() {
      return this.task.exam.quizzes.length - 1;
    }
  },

  data() {
    return {
      TASK_TYPE,
      TASK_STATUS,
      index: 0,
      timer: 0,
      page: 1
    }
  },

  methods: {
    nextQuiz() {
      this.index++;
      this.page++;
    },

    prevQuiz() {
      this.index--;
      this.page--;
    },

    runTimer() {
      setInterval(() => {
        this.timer++;
      }, 1000);
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
      const allAnswered = this.task.exam.quizzes.every(q => q.user_answer != null);

      if (allAnswered) {
        this.$confirm('Are you sure want to submit your answer ?', 'Confirm').then(() => this.submitExam())
      } else {
        const unAnswered = this.task.exam.quizzes.map((q, i) => {
          return {
            number: i+1,
            answer: q.user_answer
          }
        }).filter(q => q.answer == null).map(q => q.number).join(', ');

        this.$alert(this.$t('Mohon lengkapi jawaban soal nomor ' + unAnswered), this.$t('Perhatian'));
      }
    }
  }
}
</script>

<style>

</style>
