<template>
	<el-dialog fullscreen :visible="show" :show-close="false">
		<el-card shadow="never">
			<div class="d-flex justify-content-between">
				<div class="text-center">
					<h1 class="text-primary">{{ task.exam.exam_minimum_score }}</h1>
					<div class="text-muted">{{ $t("Minimum Score (%)") }}</div>
				</div>

				<div class="text-center">
					<h1 class="text-primary">{{ task.exam.quizzes.length }}</h1>
					<div class="text-muted">{{ $t("Total Quiz") }}</div>
				</div>

				<div class="text-center">
					<h1 class="text-success">{{ answered }}</h1>
					<div class="text-muted">{{ $t("Answered") }}</div>
				</div>

				<div class="text-center">
					<h1 class="text-primary">
						{{ task.exam.exam_max_duration || "0" }}
					</h1>
					<div class="text-muted">{{ $t("Duration (minutes)") }}</div>
				</div>

				<div class="text-center">
					<h1 class="text-danger">{{ timer }}</h1>
					<div class="text-muted">{{ $t("Timer") }}</div>
				</div>
			</div>
		</el-card>

		<div
			class="d-flex p-3 mt-3 border rounded shadow"
			style="min-height: 400px"
		>
			<h4 style="width: 60px" class="text-muted">#{{ index + 1 }}</h4>
			<div class="flex-grow-1">
				<div class="d-flex">
					<div class="mr-3 mb-3 flex-grow-1">
						<h4>{{ task.exam.quizzes[index].question }}</h4>

						<div class="d-flex my-3">
							<a
								href="#"
								class="m-2 border rounded"
								v-for="(url, i) in task.exam.quizzes[index].attachments"
								:key="i"
								@click="
									showImage = true;
									indexImage = i;
								"
							>
								<el-image
									style="height: 150px; width: 150px"
									:src="url"
								></el-image>
							</a>
						</div>

						<vue-easy-lightbox
							:visible="showImage"
							:imgs="task.exam.quizzes[index].attachments"
							:index="indexImage"
							@hide="
								showImage = false;
								indexImage = 0;
							"
						></vue-easy-lightbox>
					</div>
				</div>

				<div class="row">
					<div
						v-for="(c, i) in task.exam.quizzes[index].choices"
						:key="i"
						class="col-6 mb-3 d-flex"
					>
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

		<el-button
			v-if="answered == task.exam.quizzes.length"
			class="mt-4 btn-block"
			icon="el-icon-finished"
			type="success"
			@click="confirmSubmit"
		>
			SUBMIT
		</el-button>

		<div class="row mt-4">
			<div class="col">
				<el-button
					:disabled="index == 0"
					@click="prevQuiz"
					icon="el-icon-arrow-left"
					type="text"
					style="font-size: 20px"
					>BACK</el-button
				>
			</div>
			<div class="col text-center">
				<el-select
					class="ml-3"
					v-model="index"
					style="width: 80px; border: none; font-size: 30px"
				>
					<el-option
						v-for="i in lastIndex"
						:key="i"
						:value="i"
						:label="i + 1"
					></el-option>
				</el-select>
			</div>
			<div class="col text-right">
				<el-button
					:disabled="index == lastIndex"
					@click="nextQuiz"
					type="text"
					style="font-size: 20px"
					>NEXT
					<i class="el-icon-arrow-right"></i>
				</el-button>
			</div>
		</div>
	</el-dialog>
</template>

<script>
import { TASK_STATUS } from "@/store/modules/task";

export default {
	props: ["task", "show"],

	mounted() {
		this.runTimer();
	},

	computed: {
		allowSubmitTask() {
			return (
				this.task.assignee_id == this.$auth.user.id &&
				[TASK_STATUS.SUBMITTED, TASK_STATUS.ON_PROGRESS].includes(
					this.task.status
				)
			);
		},

		lastIndex() {
			return this.task.exam.quizzes.length - 1;
		},

		answered() {
			return this.task.exam.quizzes.filter(q => q.user_answer != null).length;
		}
	},

	data() {
		return {
			TASK_STATUS,
			index: 0,
			timer: 0,
			indexImage: 0,
			showImage: false
		};
	},

	methods: {
		nextQuiz() {
			this.index++;
		},

		prevQuiz() {
			this.index--;
		},

		runTimer() {
			setInterval(() => {
				this.timer++;
			}, 1000);
		},

		submitExam() {
			this.time_finished = new Date();
			const answer = this.task.exam.quizzes.map(q => q.user_answer);
			this.$axios
				.$post(`/api/task/submitExam/${this.task.id}`, { answer })
				.then(response => {
					this.$message({
						message: response.message,
						type: "success",
						showClose: true
					});
				})
				.catch(e => {
					this.$message({
						message: e.response.data.message,
						type: "error",
						showClose: true
					});

					if (e.response.status == 422) {
						this.errors = e.response.data.errors;
					}
				});
		},

		confirmSubmit() {
			const allAnswered = this.task.exam.quizzes.every(
				q => q.user_answer != null
			);

			if (allAnswered) {
				this.$confirm(
					"Are you sure want to submit your answer ?",
					"Confirm"
				).then(() => this.submitExam());
			} else {
				const unAnswered = this.task.exam.quizzes
					.map((q, i) => {
						return {
							number: i + 1,
							answer: q.user_answer
						};
					})
					.filter(q => q.answer == null)
					.map(q => q.number)
					.join(", ");

				this.$alert(
					this.$t("Mohon lengkapi jawaban soal nomor " + unAnswered),
					this.$t("Perhatian")
				);
			}
		}
	}
};
</script>
