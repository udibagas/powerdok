<template>
	<div class="card" v-loading="loading">
		<div class="card-header bg-primary text-white">DOCUMENT QUIZ</div>
    <div class="card-body">
      <strong>{{ document.type_name }}</strong> &nbsp; No. {{ document.number }} &nbsp; Ver. {{ document.version }}
      <h2>{{ document.title }}</h2>
      <div class="row">
        <div class="col-md-4">
          Effective Date : {{ readableDate(document.effective_date) }}
        </div>
        <div class="col-md-4">
          Expired Date : {{ readableDate(document.expired_date) }}
        </div>
        <div class="col-md-4">
          Owner : {{ document.owner.name }}
        </div>
      </div>
    </div>
    <div class="card-body">
			<div v-for="(q, index) in quizzes" :key="index" class="d-flex mb-4">
				<div class="mr-3">
					<h4 class="text-muted">#{{ index + 1 }}</h4>
				</div>
				<div class="flex-grow-1">
          <el-input
            type="textarea"
            rows="3"
            :placeholder="$t('Question')"
            v-model="q.question"
            class="mb-3"
          ></el-input>
          <el-button
            type="danger"
            size="small"
            circle
            icon="el-icon-delete"
            @click="deleteQuiz"
          ></el-button>
					<div class="row">
              <div v-for="(c, i) in q.choices" :key="i" class="col-5 mb-3 d-flex">
                <el-radio v-model="q.correct_answer" :label="i">
                  <h5 class="text-muted" style="display: inline-block">
                    {{ ["A", "B", "C", "D"][i] }}.
                  </h5>
                </el-radio>
                <el-input
                  type="textarea"
                  rows="2"
                  v-model="q.choices[i]"
                ></el-input>
              </div>
            </div>
				</div>
			</div>

			<div class="d-flex mb-4">
				<div class="mr-3">
					<h4 class="text-muted">#{{ quizzes.length + 1 }}</h4>
				</div>
				<div>
					<el-button size="small" class="btn-primary" icon="el-icon-plus" @click="newQuiz">
						{{ $t("NEW QUESTION") }}
					</el-button>
				</div>
			</div>
		</div>

		<div class="card-footer text-right">
      <el-button
        size="small"
        icon="el-icon-circle-close"
        @click.native="$router.push('/documents/manage')"
        :loading="loading"
      >CANCEL
      </el-button>
      <el-button
        size="small"
        class="btn-primary"
        icon="el-icon-success"
        @click="save"
        :loading="loading"
      >SAVE
      </el-button>
		</div>
	</div>
</template>

<script>
import dropdown from '~/mixins/dropdown'
import moment from 'moment'

export default {
	mixins: [dropdown],
  async asyncData({$axios, query}) {
    const document = await $axios.$get(`/api/document/${query.slug}`);
    return { document };
  },
  head() {
    return {
      title: `Powerdok | Manage Quiz - ${this.document.title}`,
    };
  },
  data() {
    return {
      loading: false,
      quizzes: [
        {
          question: '',
          choices: [
            'Choice 1',
            'Choice 2',
            'Choice 3',
            'Choice 4',
          ],
          correct_answer: null
        }
      ],
    }
  },
  methods: {
    newQuiz() {
      this.quizzes.push({
        document_id: '',
        question: '',
        choices: [
          'Choice 1',
          'Choice 2',
          'Choice 3',
          'Choice 4',
        ],
        correct_answer: null
      });
    },
    save() {
      this.loading = true;
      const data = { document_id: this.document.id, quizzes: this.quizzes };
      this.$axios.$post(`/api/document/quiz/${this.document.id}`, data).then(response => {
        this.$message({
          message: response.message,
          type: 'success',
          showClose: true
        })
        this.getQuizByDepartment();
      }).catch(e => {
         this.$message({
          message: e.response.data.message,
          type: 'error',
          showClose: true
        })
      }).finally(() => this.loading = false)
    },
    getQuizByDepartment() {
      this.$axios.$get(`/api/document/quiz/${this.document.id}`).then(response => {
        this.quizzes = response;
      }).catch(e => {
        this.$message({
          message: e.response.data.message,
          type: 'error',
          showClose: true
        })
      })
    },
    readableDate(date) {
      return moment(date).format('DD-MMM-YYYY')
    }
  },
  mounted() {
		this.getQuizByDepartment()
  }
}
</script>

<style>
</style>
