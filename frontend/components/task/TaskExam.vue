<template>
	<div>
		<el-card class="mb-3" shadow="never">
			<div class="row">
				<div class="col">
					<div class="text-muted">{{ $t("Minimum Score (%)") }}</div>
					<h1 class="text-primary">{{ exam.exam_minimum_score }}</h1>
				</div>

				<div class="col text-center">
					<div class="text-muted">{{ $t("Total Quiz") }}</div>
					<h1 class="text-primary">{{ exam.quizzes.length }}</h1>
				</div>

				<div class="col text-right">
					<div class="text-muted">{{ $t("Duration (minutes)") }}</div>
					<h1 class="text-primary">{{ exam.exam_max_duration || "0" }}</h1>
				</div>
			</div>

			<div
				class="row mt-4"
				v-if="
					task.status == TASK_STATUS.FINISHED ||
					task.status == TASK_STATUS.CLOSED
				"
			>
				<div class="col">
					<div class="text-muted">{{ $t("Score") }}</div>
					<h1 class="text-success">
						{{ exam.score }}
						<small
							>({{ exam.correct_answer }} / {{ exam.quizzes.length }})</small
						>
					</h1>
				</div>

				<div class="col text-center">
					<div class="text-muted">{{ $t("Status") }}</div>
					<h1
						:class="{
							'text-success': exam.passed,
							'text-danger': !exam.passed,
						}"
					>
						{{ exam.passed ? $t("PASSED") : $t("FAILED") }}
					</h1>
				</div>

				<div class="col text-right">
					<div class="text-muted">{{ $t("Duration") }}</div>
					<h1 class="text-warning">{{ exam.duration }}</h1>
				</div>
			</div>

			<div class="text-center my-3" v-if="exam.time_finished == null">
				<el-button type="danger" icon="el-icon-timer" @click="confirmStart">
					{{ $t("START EXAM") }}
				</el-button>
			</div>
		</el-card>

		<ExamDialog
			v-if="start"
			:task="task"
			:exam="exam"
			:show="showDialog"
			@close="showDialog = false"
			@refresh="
				getData();
				$emit('refresh');
			"
		/>

		<div
			v-if="
				task.status == TASK_STATUS.FINISHED || task.status == TASK_STATUS.CLOSED
			"
		>
			<el-card
				shadow="never"
				v-for="(quiz, index) in exam.quizzes"
				class="mb-2"
				:key="index"
				:class="{
					'border-success':
						quiz.correct_answer == quiz.user_answer &&
						task.status == TASK_STATUS.FINISHED,
					'border-danger':
						quiz.correct_answer != quiz.user_answer &&
						task.status == TASK_STATUS.FINISHED,
				}"
			>
				<div class="d-flex">
					<div class="mr-3 text-center">
						<h4 class="text-muted">#{{ index + 1 }}</h4>
						<i
							style="font-size: 30px"
							:class="{
								'el-icon-circle-check text-success':
									quiz.correct_answer == quiz.user_answer &&
									task.status == TASK_STATUS.FINISHED,
								'el-icon-circle-close text-danger':
									quiz.correct_answer != quiz.user_answer &&
									task.status == TASK_STATUS.FINISHED,
							}"
						></i>
					</div>
					<div class="flex-grow-1">
						<div class="d-flex">
							<div class="mr-3 mb-3 flex-grow-1">
								<p class="text-justify">{{ quiz.question }}</p>

								<ImageList :images="quiz.attachments" />
							</div>
						</div>

						<div class="row">
							<div
								v-for="(c, i) in quiz.choices"
								class="col-6 mb-3 d-flex"
								:key="i"
								:class="{
									'text-success font-weight-bold': quiz.correct_answer == i,
									'text-danger font-weight-bold':
										quiz.user_answer != quiz.correct_answer &&
										quiz.user_answer == i,
								}"
							>
								<strong class="mr-2"> {{ ["A", "B", "C", "D"][i] }}. </strong>
								<p class="text-justify">
									{{ quiz.choices[i] }}
								</p>
							</div>
						</div>
					</div>
				</div>
			</el-card>
		</div>
	</div>
</template>

<script>
import { TASK_STATUS, TASK_TYPE } from "@/store/modules/task";

export default {
	props: ["task"],

	data() {
		return {
			TASK_TYPE,
			TASK_STATUS,
			visible: false,
			start: false,
			time_start: null,
			time_finished: null,
			showDialog: false,
			exam: { quizzes: [] }
		};
	},

	mounted() {
		this.getData();
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

		taskIsDone() {
			return [TASK_STATUS.FINISHED, TASK_STATUS.CLOSED].includes(
				this.task.status
			);
		}
	},

	methods: {
		confirmStart() {
			this.$confirm(
				this.$t(
					"Are you sure you want to start the exam? This action can not be undo!",
					this.$t("Confirm"),
					{ type: "warning" }
				)
			)
				.then(() => {
					this.$axios
						.$post(`/api/task/startExam/${this.task.id}`)
						.then(response => {
							this.start = true;
							this.time_start = response.time_start;
							this.showDialog = true;
						})
						.catch(e => {
							this.$message({
								message: e.response.data.message,
								type: "error",
								showClose: true
							});
						});
				})
				.catch(e => console.log(e));
		},

		getData() {
			this.$axios
				.$get(`/api/task/exam/${this.task.id}`)
				.then(response => (this.exam = response));
		}
	}
};
</script>
