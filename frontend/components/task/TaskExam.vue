<template>
	<div>
		<el-card
			v-if="task.status != TASK_STATUS.FINISHED"
			class="mb-3 text-center"
			shadow="hover"
		>
			<a href="#" @click.prevent="confirmStart">
				<h3>START EXAM</h3>
			</a>
		</el-card>

		<ExamDialog :task="task" :show="showDialog" />

		<el-card
			class="mb-3"
			v-if="
				task.status == TASK_STATUS.FINISHED || task.status == TASK_STATUS.CLOSED
			"
		>
			<div class="row">
				<div class="col">
					<div class="text-muted">
						{{ $t("Score") }}
					</div>
					<h1>
						{{ task.exam.score }}
						<small
							>({{ task.exam.correct_answer }} /
							{{ task.exam.quizzes.length }})</small
						>
					</h1>
				</div>
				<div class="col">
					<div class="col text-muted">
						{{ $t("Time") }}
					</div>
				</div>
				<div class="col-md-2">
					<div class="text-muted">
						{{ $t("Status") }}
					</div>
					<h1
						:class="{
							'text-success': task.exam.passed,
							'text-danger': !task.exam.passed,
						}"
					>
						{{ task.exam.passed ? $t("PASSED") : $t("FAILED") }}
					</h1>
				</div>
			</div>
		</el-card>

		<div
			v-if="
				task.status == TASK_STATUS.FINISHED || task.status == TASK_STATUS.CLOSED
			"
		>
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
						<i
							style="font-size: 30px"
							:class="{
								'el-icon-circle-check text-success':
									e.correct_answer == e.user_answer &&
									task.status == TASK_STATUS.FINISHED,
								'el-icon-circle-close text-danger':
									e.correct_answer != e.user_answer &&
									task.status == TASK_STATUS.FINISHED,
							}"
						></i>
					</div>
					<div class="flex-grow-1">
						<div class="d-flex">
							<div class="mr-3 mb-3 flex-grow-1">
								<h4>{{ e.question }}</h4>

								<div class="row">
									<div
										class="col-md-2"
										v-for="(url, i) in e.attachments"
										:key="i"
									>
										<a
											href="#"
											@click.prevent="
												index = i;
												visible = true;
											"
										>
											<el-image
												class="my-3 border mr-3 rounded"
												style="height: 100px; width: 100px"
												:src="url"
											></el-image>
										</a>
									</div>
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
							<div
								v-for="(c, i) in e.choices"
								:key="i"
								class="col-5 mb-3 d-flex"
								:class="{
									'text-success font-weight-bold':
										(e.user_answer == e.correct_answer) == i,
									'text-danger font-weight-bold':
										e.user_answer != e.correct_answer && e.user_answer == i,
								}"
							>
								<strong class="mr-2"> {{ ["A", "B", "C", "D"][i] }}. </strong>
								{{ e.choices[i] }}
								<!-- <i v-if="e.user_answer == e.correct_answer == i" style="font-size:15px" class="el-icon-check text-success"></i>
                <i v-if="e.user_answer != e.correct_answer && e.user_answer == i" style="font-size:15px" class="el-icon-close text-danger"></i> -->
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
			index: 0,
			start: false,
			time_start: null,
			time_finished: null,
			showDialog: false
		};
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
			this.start = true;
			this.time_start = new Date();
			this.showDialog = true;
		}
	}
};
</script>
