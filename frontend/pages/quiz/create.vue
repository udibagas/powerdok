<template>
	<div class="card">
		<div class="card-header bg-primary text-white">DOCUMENT QUIZ</div>
		<div class="card-body">
			<el-form label-position="left" label-width="150px">
				<el-form-item label="Related Document">
					<el-select
						v-model="document_id"
						style="width: 100%"
						placeholder="Related Document"
					></el-select>
				</el-form-item>
			</el-form>

			<div v-for="(q, index) in quizzes" :key="index" class="d-flex mb-4">
				<div class="mr-3">
					<h4 class="text-muted">#{{ index + 1 }}</h4>
				</div>
				<div class="flex-grow-1">
					<el-input
						type="textarea"
						rows="5"
						:placeholder="$t('Question')"
						v-model="q.question"
						class="mb-3"
					></el-input>

					<div class="row">
						<div v-for="(c, i) in q.choices" :key="i" class="col-6 mb-3 d-flex">
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
					<el-button class="btn-primary" icon="el-icon-plus" @click="newQuiz">
						{{ $t("NEW QUESTION") }}
					</el-button>
				</div>
			</div>
		</div>

		<div class="card-footer text-right">
			<el-button class="btn-primary" icon="el-icon-check">SAVE</el-button>
		</div>
	</div>
</template>

<script>
export default {
  data() {
    return {
      document_id: null,
      quizzes: [
        {
          document_id: '',
          question: '',
          choices: [
            'Choice 1',
            'Choice 2',
            'Choice 3',
            'Choice 4',
          ],
          correct_answer: null
        }
      ]
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
    }
  }

}
</script>

<style>
</style>
