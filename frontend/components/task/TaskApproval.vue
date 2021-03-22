<template>
	<el-card shadow="never" class="mt-3">
		<div class="d-flex justify-content-between" slot="header">
			<div>{{ $t("APPROVALS") }}</div>
			<el-button
				size="small"
				type="text"
				icon="el-icon-edit"
				@click="showForm = true"
			>
				{{
					$t(
						submittedApprovals.length > 0 ? "EDIT APPROVAL" : "REQUEST APPROVAL"
					)
				}}
			</el-button>
		</div>

		<div v-if="submittedApprovals.length > 0">
			<el-card
				shadow="hover"
				v-for="approval in submittedApprovals"
				:key="approval.id"
				class="mb-3"
			>
				<div class="media">
					<el-avatar
						class="mr-3 border-2 border-success"
						:size="45"
						icon="el-icon-user"
					></el-avatar>

					<div class="media-body">
						<div class="d-flex justify-content-between">
							<div>
								<strong>{{
									approval.user_id == $auth.user.id
										? $t("Me")
										: approval.user.name
								}}</strong>

								<span class="text-muted">
									&bull;
									{{ approval.user.position }} |
									{{
										approval.user.department
											? approval.user.department.name
											: "N/A"
									}}
									<br />
									<i>
										{{
											$moment(approval.updated_at).lang($i18n.locale).fromNow()
										}}
									</i>
								</span>
							</div>

							<div>
								<el-tag
									v-if="approval.status !== null"
									effect="dark"
									:type="approval.status ? 'success' : 'danger'"
									>{{ approval.status ? $t("APPROVED") : $t("DECLINED") }}
								</el-tag>
								<el-tag v-else effect="dark" type="info"
									>{{ $t("WAITING") }}
								</el-tag>
							</div>
						</div>

						<!-- approval form -->
						<div
							class="my-3"
							v-if="
								approval.user_id == $auth.user.id && approval.status == null
							"
						>
							<el-input
								type="textarea"
								:autosize="{ minRows: 2, maxRows: 10 }"
								v-model="approval.note"
								placeholder="Note"
							></el-input>
							<div class="mt-3">
								<!-- <el-button
								size="small"
								type="danger"
								@click="approve(approval.id, false, approval.note)"
							>
								<i class="el-icon-close mr-1"></i>{{ $t("DECLINE") }}
							</el-button> -->
								<el-button
									size="small"
									type="success"
									@click="approve(approval.id, true, approval.note)"
								>
									<i class="el-icon-check mr-1"></i>{{ $t("APPROVE") }}
								</el-button>
							</div>
						</div>

						<div
							class="my-3"
							v-if="approval.status != null && approval.note"
							v-html="approval.note"
						></div>
					</div>
				</div>
			</el-card>
		</div>

		<div v-else class="text-center border shadow rounded bg-white">
			<h5 class="text-muted" style="line-height: 200px">NO APPROVAL FOUND</h5>
		</div>

		<RequestApprovalForm
			:show="showForm"
			:task="task"
			:approvals="approvals"
			@close="showForm = false"
			@refresh="getData"
		/>
	</el-card>
</template>

<script>
export default {
	props: ["task"],

	computed: {
		submittedApprovals() {
			return this.approvals.filter(a => {
				return "user" in a;
			});
		}
	},

	mounted() {
		this.getData();
	},

	data() {
		return {
			approvals: [],
			showForm: false
		};
	},

	methods: {
		approve(id, status, note) {
			this.$confirm(
				"Are you sure want to save your response ?",
				"Confirm"
			).then(() => {
				this.$axios
					.$post(`/api/task/approve/${this.task.id}`, { id, status, note })
					.then(response => {
						this.$message({
							message: response.message,
							type: "success",
							showClose: true
						});

						this.errors = {};
						this.getData();
						this.$emit("refresh");
					})
					.catch(e => {
						if (e.response.status == 422) {
							this.errors = e.response.data.errors;
						}

						this.$message({
							message: e.response.data.message,
							type: "error",
							showClose: true
						});
					});
			});
		},
		getData() {
			this.$axios
				.$get(`/api/task/approvals/${this.task.id}`)
				.then(response => (this.approvals = response));
		}
	}
};
</script>
