<template>
	<div class="card" v-loading="loading">
		<div class="card-header bg-primary text-white">DOCUMENT QUIZ</div>
    <div class="card-body">
      <strong>{{ document.type_name }}</strong> &nbsp; No. {{ document.number }} &nbsp; Ver. {{ document.version }}
      <h2>{{ document.title }}</h2>
      <div class="media mt-3">
        <el-avatar class="mr-3"></el-avatar>
        <div class="media-body">
          <strong>{{ document.owner.name }}</strong>
          <span class="text-muted">
            &bull; {{ $moment(document.created_at).fromNow() }}
          </span>
          <div class="text-muted">
            {{ document.owner.position }} |
            {{ document.owner.department ? document.owner.department.name : "N/A" }}
          </div>
        </div>
        <div class="media-body">
          <div class="text-muted">
            {{ $t("Effective Date") }}
          </div>
          <strong>{{ readableDate(document.effective_date) }}</strong>
        </div>
        <div class="media-body">
          <div class="text-muted">
            {{ $t("Expired Date") }}
          </div>
          <strong>{{ readableDate(document.expired_date) }}</strong>
        </div>
      </div>
      <el-form class="mt-5" label-width="160px" label-position="left">
        <div class="row">
          <div class="col">
            <el-form-item label="* Minimum Score :" :class="{ 'is-error': errors.exam_minimum_score }">
              <el-input-number
                v-model="document.exam_minimum_score"
                :step="5"
                :max="100"
                :min="0"
                step-strictly
                size="small"
              ></el-input-number>

                <div class="el-form-item__error ml-2" v-if="errors.exam_minimum_score">
                  {{ errors.exam_minimum_score.join(", ") }}
                </div>
            </el-form-item>
          </div>
          <div class="col">
            <el-form-item label="* Maximum Duration :" :class="{ 'is-error': errors.exam_max_duration }">
              <el-input-number
                v-model="document.exam_max_duration"
                :step="5"
                :max="120"
                :min="0"
                step-strictly
                size="small"
                class="mr-2"
              ></el-input-number>minutes

              <div class="el-form-item__error ml-2" v-if="errors.exam_max_duration">
                {{ errors.exam_max_duration.join(", ") }}
              </div>
            </el-form-item>
          </div>
        </div>
      </el-form>
    </div>
    <div class="card-body">
			<div v-for="(q, index) in quizzes" :key="index" class="d-flex mb-4">
				<div class="mr-3">
					<h4 class="text-muted">#{{ index + 1 }}</h4>
				</div>
				<div class="flex-grow-1">
          <div class="d-flex">
            <div class="mr-3 mb-3 flex-grow-1">
              <el-alert class="mb-3" type="error" title="Validation error" v-if="Object.values(errors).length > 0">
                <ul>
                  <template v-for="(error, i) in Object.entries(errors)">
                    <li v-if="error[0] == `quizzes.${index}.question`" :key="i">
                      {{error[1].join(',')}}
                    </li>
                    <li v-if="error[0] == `quizzes.${index}.choices`" :key="i">
                      {{error[1].join(',')}}
                    </li>
                    <li v-if="error[0] == `quizzes.${index}.correct_answer`" :key="i">
                      {{error[1].join(',')}}
                    </li>
                  </template>
                </ul>
              </el-alert>

              <el-input
                type="textarea"
                rows="3"
                :placeholder="$t('Question')"
                v-model="q.question"
                class="mb-2"
              ></el-input>

              <div class="d-flex flex-wrap">
                <el-image
                  class="mb-3 border mr-3 rounded"
                  style="width:150px;height:150px;"
                  fit="cover"
                  v-for="image in q.attachments"
                  :src="image.url" :key="image.id"
                ></el-image>

                <el-upload
                  class="mb-3"
                  action=""
                  :data="{quiz_index: index}"
                  multiple
                  :show-file-list="false"
                  :loading="loading"
                  :file-list="q.attachments.map(a => {
                    const { name, url: path } = a;
                    return { name, path }
                  })"
                  :on-remove="handleRemove"
                  :on-success="handleUploadFileSuccess"
                  :on-error="handleUploadFileError"
                  :http-request="upload"
                >
                  <div style="width:150px;line-height:150px;" class="border rounded">
                    <i class="el-icon-upload2"></i> UPLOAD IMAGE
                  </div>
                </el-upload>
              </div>
            </div>
            <div>
              <el-button
                type="danger"
                size="small"
                circle
                icon="el-icon-delete"
                @click="deleteQuiz(index, q.id)"
              ></el-button>
            </div>
          </div>

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
                :placeholder="$t('Choice')"
              ></el-input>
            </div>
          </div>
				</div>
			</div>

			<div class="mb-4">
        <el-card shadow="hover">
          <div @click="newQuiz" class="text-center text-primary" style="line-height:120px;cursor:pointer;font-size:20px">
            <i class="el-icon-plus"></i>
            {{ $t("NEW QUESTION") }}
          </div>
        </el-card>
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
    const document = await $axios.$get(`/api/document/${query.id}`);
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
      exam_minimum_score: '',
      exam_max_duration: '',
      quizzes: [],
      errors: {}
    }
  },
  methods: {
    newQuiz() {
      this.quizzes.push({
        question: '',
        attachments: [],
        choices: [
          '',
          '',
          '',
          '',
        ],
        correct_answer: null
      });
    },
    deleteQuiz(index, id) {
      this.$confirm('Are you sure want to delete this question?', 'Confirm', {type: 'warning'}).then(() => {
        if (id) {
          this.$axios.$delete(`api/document/quiz/${id}`).then(r => {
            this.$message({
              message: r.message,
              type: 'success',
              showClose: true
            })
            this.quizzes.splice(index, 1)
          }).catch(e => {
            this.$message({
              message: e.response.data.message,
              type: 'error',
              showClose: true
            })
          }).finally(() => this.loading = false)
        } else {
          this.quizzes.splice(index, 1)
        }
      })
    },
    save() {
      this.loading = true;
      const data = { document_id: this.document.id, quizzes: this.quizzes, minimum_score: this.document.minimum_score };
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
          });

          if (e.response.status == 422) {
            this.errors = e.response.data.errors
          }

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
    },

    upload(params) {
      console.log(params);
      const { file, onError, onSuccess, onProgress, data } = params;

      let formData = new FormData();
      formData.append('file', file);
      formData.append('data', JSON.stringify(data));

      this.$axios.$post('/api/upload', formData, {
        headers: { 'Content-Type': 'multipart/form-data' },
        onUploadProgress: (e) => {
          let percent = (e.loaded / e.total * 100) | 0;
          onProgress( { percent } );
        },
      }).then((response) => onSuccess(response)).catch(e => onError(e.response))
    },

    handleRemove(file, fileList) {
      console.log(file, fileList);
    },

		handleUploadFileSuccess(res, file, fileList) {
      this.$message({ message: res.message, type: 'success' });
      let data = JSON.parse(res.data);

      if (this.quizzes[data.quiz_index].attachments == null) {
        this.quizzes[data.quiz_index].attachments = [];
      }
      const { name, path, user_id, url } = res
      this.quizzes[data.quiz_index].attachments.push({ name, path, user_id, url });
      this.$forceUpdate();
		},

		handleUploadFileError(err, file, fileList) {
      console.log(err);
      let message =  ''

			if (err.status == 413) {
				message = this.$t('Failed to upload document. File too big.')
			}

			if (err.status == 422) {
				message = err.data.errors.file[0]
			}

			if (err.status == 500) {
				message = err.data.message
			}

			this.$message({
				message: message,
				type: 'error',
				showClose: true,
				duration: 10000,
			})
		}
  },
  mounted() {
		this.getQuizByDepartment()
  }
}
</script>

<style>
</style>
