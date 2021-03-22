<template>
	<div>
		<div class="border rounded shadow bg-white d-flex">
			<div class="flex-grow-1 p-3">
				<div class="d-flex justify-content-between">
					<div class="mt-3">
						<h3 class="mb-0">
							<span class="text-muted"> #{{ task.id }} </span>
							{{ task.title }}
						</h3>

						{{
							$moment(task.created_at)
								.lang($i18n.locale)
								.format("DD-MMM-YYYY HH:mm")
						}}

						(<i> {{ $moment(task.created_at).lang($i18n.locale).fromNow() }} </i
						>)
					</div>

					<div class="mt-3">
						<el-dropdown
							split-button
							type="primary"
							v-if="showAction"
							@command="handleCommand"
						>
							<i class="el-icon-setting"></i>
							{{ $t("Action") }}
							<el-dropdown-menu slot="dropdown">
								<el-dropdown-item
									v-if="!task.is_closed"
									command="edit"
									icon="el-icon-edit"
								>
									{{ $t("Edit Task") }}
								</el-dropdown-item>

								<el-dropdown-item
									v-if="task.status == TASK_STATUS.FINISHED"
									icon="el-icon-lock"
									command="close"
								>
									{{ $t("Close Task") }}
								</el-dropdown-item>

								<el-dropdown-item
									v-if="!task.is_closed"
									icon="el-icon-circle-close"
									command="void"
								>
									{{ $t("Void Task") }}
								</el-dropdown-item>

								<el-dropdown-item
									v-if="task.status == TASK_STATUS.NEW"
									icon="el-icon-delete"
									command="delete"
								>
									{{ $t("Delete Task") }}
								</el-dropdown-item>
							</el-dropdown-menu>
						</el-dropdown>

						<el-button
							class="ml-1"
							type="primary"
							icon="el-icon-refresh"
							@click="fetchData"
						></el-button>
					</div>
				</div>

				<div class="row mt-4 p-3 rounded border-top border-bottom mb-3">
					<div class="col-md-3">
						<div class="text-muted mb-1">
							{{ $t("Type") }}
						</div>
						<h5 class="text-info">{{ task.type_name }}</h5>
					</div>

					<div class="col-md-3">
						<div class="text-muted mb-1">
							{{ $t("Priority") }}
						</div>
						<h5 :class="`text-${priorityColors[task.priority_label]}`">
							{{ task.priority_label }}
						</h5>
					</div>

					<div class="col-md-3">
						<div class="text-muted mb-1">
							{{ $t("Status") }}
						</div>
						<h5 :class="`text-${statusColors[task.status_label]}`">
							{{ task.status_label }}
						</h5>
					</div>

					<div class="col-md-3">
						<div class="text-muted mb-1">
							{{ $t("Due Date") }}
						</div>
						<h5 class="text-danger">
							{{
								task.due_date
									? $moment(task.due_date).format("DD-MMM-YYYY")
									: "N/A"
							}}
						</h5>
					</div>
				</div>

				<div class="border rounded shadow p-3">
					<div class="d-flex justify-content-between">
						<div>
							<div class="text-primary mb-2">{{ $t("From") }}:</div>
							<div class="media">
								<el-avatar
									class="mr-3"
									:size="45"
									icon="el-icon-user"
								></el-avatar>
								<div class="media-body">
									<strong>{{ task.user.name }}</strong>
									<br />
									<span class="text-muted">
										{{ task.user.position }} |
										{{
											task.user.department ? task.user.department.name : "N/A"
										}}
										<br />
										<i> </i>
									</span>
								</div>
							</div>
						</div>

						<div>
							<div class="text-primary mb-2">{{ $t("To") }}:</div>
							<div class="media">
								<el-avatar
									class="mr-3"
									:size="45"
									icon="el-icon-user"
								></el-avatar>
								<div class="media-body">
									<strong>{{ task.assignee.name }}</strong>
									<br />
									<span class="text-muted">
										{{ task.assignee.position }} |
										{{
											task.assignee.department
												? task.assignee.department.name
												: "N/A"
										}}
									</span>
								</div>
							</div>
						</div>
					</div>

					<hr />

					<div v-html="task.description"></div>
				</div>

				<div v-if="task.document" class="mt-3 border shadow rounded p-3">
					<div class="text-muted mb-3">
						<i class="el-icon-paperclip"></i>
						{{ $t("Related Document") }}
					</div>
					<div class="media">
						<i class="el-icon-document mr-2" style="font-size: 40px"></i>
						<div class="media-body">
							<div>
								<strong>{{ task.document.type_name }}</strong> &nbsp; No.
								{{ task.document.latest_version.number }} &nbsp; Ver.
								{{ task.document.latest_version.version }}
							</div>
							<nuxt-link :to="`/documents/${task.document.id}`">
								{{ task.document.title }}
							</nuxt-link>
						</div>
					</div>
				</div>

				<Attachments
					class="mt-3 border rounded shadow p-3"
					:url="`/api/task/attachments/${task.id}`"
				/>
			</div>

			<TaskSummary :task="task" />
		</div>

		<TaskApproval
			v-if="
				task.type == TASK_TYPE.DOCUMENT_REVIEW &&
				![TASK_STATUS.NEW, TASK_STATUS.ON_PROGRESS].includes(task.status)
			"
			:task="task"
			@refresh="fetchData"
		/>

		<DocumentForm
			class="mt-3"
			v-if="task.type == TASK_TYPE.DOCUMENT_REVIEW"
			:task="task"
			@refresh="fetchData"
		/>

		<Atestation
			class="mt-3"
			:task="task"
			v-if="task.type == TASK_TYPE.ATESTATION"
			@refresh="fetchData"
		/>

		<TaskExam
			class="mt-3"
			v-if="task.type == TASK_TYPE.EXAMINATION"
			:task="task"
			@refresh="fetchData"
		/>

		<Comments
			:allowComment="
				![TASK_STATUS.CLOSED, TASK_STATUS.VOID].includes(task.status)
			"
			:url="`/api/task/comments/${task.id}`"
		/>

		<TaskForm
			:show="showForm"
			:model="model"
			url="/api/task"
			@close="showForm = false"
			@refresh="fetchData"
		/>
	</div>
</template>

<script>
import { TASK_STATUS, TASK_TYPE } from "@/store/modules/task";
import { mapState } from "vuex";

export default {
	data() {
		return {
			document: "",
			showForm: false,
			model: {},
			TASK_TYPE,
			TASK_STATUS
		};
	},

	computed: {
		showAction() {
			return (
				this.task.user_id == this.$auth.user.id &&
				this.task.status != TASK_STATUS.CLOSED &&
				this.task.status != TASK_STATUS.VOID
			);
		},
		...mapState(["priorityColors", "statusColors", "statusList"])
	},

	async asyncData({ $axios, params }) {
		const task = await $axios.$get(`/api/task/${params.id}`);
		return { task };
	},

	head() {
		return {
			title: `Powerdok | Task - ${this.task.title}`
		};
	},

	methods: {
		async fetchData() {
			this.task = await this.$axios.$get(`/api/task/${this.task.id}`);
		},

		handleCommand(command) {
			if (command == "edit") {
				this.model = JSON.parse(JSON.stringify(this.task));
				this.showForm = true;
				return;
			}

			this.$confirm(this.$t("Anda yakin?"), this.$t("Confirm"), {
				type: "warning"
			})
				.then(() => {
					switch (command) {
						case "close":
							this.closeTask();
							break;

						case "void":
							this.voidTask();
							break;

						case "delete":
							this.deleteTask();
							break;
					}
				})
				.catch(e => console.log(e));
		},

		closeTask() {
			this.$axios
				.$post(`/api/task/close/${this.task.id}`)
				.then(response => {
					this.$message({
						message: response.message,
						type: "success",
						showClose: true
					});
					this.fetchData();
				})
				.catch(e => {
					this.$message({
						message: e.response.data.message,
						type: "error",
						showClose: true
					});
				});
		},

		voidTask() {
			this.$axios
				.$post(`/api/task/void/${this.task.id}`)
				.then(response => {
					this.$message({
						message: response.message,
						type: "success",
						showClose: true
					});
					this.fetchData();
				})
				.catch(e => {
					this.$message({
						message: e.response.data.message,
						type: "error",
						showClose: true
					});
				});
		},

		deleteTask() {
			this.$axios
				.$delete(`/api/task/${this.task.id}`)
				.then(response => {
					this.$message({
						message: response.message,
						type: "success",
						showClose: true
					});
					this.$router.push("/task/manage");
				})
				.catch(e => {
					this.$message({
						message: e.response.data.message,
						type: "error",
						showClose: true
					});
				});
		}
	}
};
</script>
