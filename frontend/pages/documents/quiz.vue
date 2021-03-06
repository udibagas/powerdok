<template>
	<div v-loading="loading">
		<el-card class="mb-3" shadow="hover">
			<strong>{{ document.type_name }}</strong> &nbsp; No.
			{{ document.number }} &nbsp; Ver. {{ document.version }}
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
						{{
							document.owner.department ? document.owner.department.name : "N/A"
						}}
					</div>
				</div>
				<div class="media-body">
					<div class="text-muted">
						{{ $t("Effective Date") }}
					</div>
					<strong>{{
						$moment(document.effective_date).format("DD-MMM-YYYY")
					}}</strong>
				</div>
				<div class="media-body">
					<div class="text-muted">
						{{ $t("Expired Date") }}
					</div>
					<strong>{{
						$moment(document.expired_date).format("DD-MMM-YYYY")
					}}</strong>
				</div>
			</div>
		</el-card>

		<el-card class="mb-3" shadow="hover">
			<div class="d-flex justify-content-between">
				<div>
					<div class="text-muted mb-2">{{ $t("Exam Minimum Score") }} (%)</div>
					<input
						type="number"
						max="100"
						class="form-control form-control-lg"
						v-model="document.exam_minimum_score"
					/>
				</div>
				<div>
					<div class="text-muted mb-2">
						{{ $t("Exam Duration") }} ({{ $t("minutes") }})
					</div>
					<input
						type="number"
						class="form-control form-control-lg"
						v-model="document.exam_max_duration"
					/>
				</div>
			</div>
		</el-card>

		<el-card
			v-for="(q, index) in quizzes"
			:key="index"
			class="mb-3"
			shadow="hover"
		>
			<div class="d-flex">
				<div class="mr-3">
					<h4 class="text-muted">#{{ index + 1 }}</h4>
				</div>
				<SingleQuizForm
					:index="index"
					:quiz="q"
					:errors="errors"
					@delete="deleteQuiz"
				/>
			</div>
		</el-card>

		<el-card shadow="hover">
			<div
				@click="newQuiz"
				class="text-center text-primary"
				style="
					line-height: 120px;
					cursor: pointer;
					font-size: 20px;
					border: 1px dashed #ddd;
				"
			>
				<i class="el-icon-plus"></i>
				{{ $t("NEW QUESTION") }}
			</div>
		</el-card>

		<el-card class="text-right my-3" shadow="hover">
			<el-button
				icon="el-icon-circle-close"
				@click.native="$router.push('/documents/manage')"
				:loading="loading"
				>CANCEL
			</el-button>
			<el-button
				type="primary"
				icon="el-icon-success"
				@click="save"
				:loading="loading"
				>SAVE
			</el-button>
		</el-card>
	</div>
</template>

<script>
export default {
	async asyncData({ $axios, query }) {
		const document = await $axios.$get(`/api/document/${query.id}`);
		return { document };
	},

	head() {
		return {
			title: `Powerdok | Manage Quiz - ${this.document.title}`
		};
	},

	data() {
		return {
			loading: false,
			exam_minimum_score: "",
			exam_max_duration: "",
			quizzes: [],
			errors: {}
		};
	},

	methods: {
		newQuiz() {
			this.quizzes.push({
				question: "",
				attachments: [],
				choices: ["", "", "", ""],
				correct_answer: null
			});
		},

		deleteQuiz(index, id) {
			this.$confirm("Are you sure want to delete this question?", "Confirm", {
				type: "warning"
			}).then(() => {
				if (id) {
					this.$axios
						.$delete(`api/document/quiz/${id}`)
						.then(r => {
							this.$message({
								message: r.message,
								type: "success",
								showClose: true
							});
							this.quizzes.splice(index, 1);
						})
						.catch(e => {
							this.$message({
								message: e.response.data.message,
								type: "error",
								showClose: true
							});
						})
						.finally(() => (this.loading = false));
				} else {
					this.quizzes.splice(index, 1);
				}
			});
		},

		save() {
			this.loading = true;

			const data = {
				document_id: this.document.id,
				quizzes: this.quizzes,
				exam_minimum_score: this.document.exam_minimum_score,
				exam_max_duration: this.document.exam_max_duration
			};

			this.$axios
				.$post(`/api/document/quiz/${this.document.id}`, data)
				.then(response => {
					this.$message({
						message: response.message,
						type: "success",
						showClose: true
					});
					this.getQuizByDocument();
					this.errors = {};
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
				})
				.finally(() => (this.loading = false));
		},

		getQuizByDocument() {
			this.$axios
				.$get(`/api/document/quiz/${this.document.id}`)
				.then(response => {
					this.quizzes = response;
				})
				.catch(e => {
					this.$message({
						message: e.response.data.message,
						type: "error",
						showClose: true
					});
				});
		}
	},
	mounted() {
		this.getQuizByDocument();
	}
};
</script>
