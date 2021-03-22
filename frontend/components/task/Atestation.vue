<template>
	<el-card shadow="hover">
		<content-placeholders v-if="fetching">
			<content-placeholders-heading />
			<content-placeholders-text :lines="3" />
		</content-placeholders>

		<div v-else>
			<h2 class="my-3">{{ document.title }}</h2>

			<div class="border-top border-bottom py-3 my-3">
				<div class="d-flex justify-content-between">
					<div>
						<div class="text-muted">Type</div>
						<h5>{{ document.type_name }}</h5>
					</div>

					<div>
						<div class="text-muted">Number</div>
						<h5>#{{ document.versions[index].number }}</h5>
					</div>

					<div>
						<div class="text-muted">Version</div>
						<h5>Ver. {{ document.versions[index].version }}</h5>
					</div>

					<div>
						<div class="text-muted">Effective Date</div>
						<h5>
							{{
								$moment(document.versions[index].effective_date).format(
									"DD-MMM-YYYY"
								)
							}}
						</h5>
					</div>

					<div>
						<div class="text-muted">Expired Date</div>
						<h5>
							{{
								$moment(document.versions[index].expired_date).format(
									"DD-MMM-YYYY"
								)
							}}
						</h5>
					</div>
				</div>
			</div>

			<div
				v-html="document.versions[index].body"
				class="border p-3 rounded shadow"
			></div>

			<el-card v-if="!task.is_closed" shadow="hover" class="mt-3">
				<div class="d-flex justify-content-between">
					<el-checkbox v-model="confirmed"
						>Saya telah membaca dan memahami dokumen ini dan berkomitmen untuk
						mengimplementasikannya</el-checkbox
					>
					<el-button type="primary" @click="confirm" :disabled="!confirmed"
						>SUBMIT</el-button
					>
				</div>
			</el-card>
		</div>
	</el-card>
</template>

<script>
export default {
	props: ["task"],

	data() {
		return {
			document: {},
			index: 0,
			fetching: true,
			confirmed: false
		};
	},

	methods: {
		confirm() {
			this.$confirm(
				this.$t(
					"Anda yakin telah membaca dan memahami dokumen ini dan berkomitmen untuk mengimplementasikannya?"
				),
				this.$t("Confirm"),
				{ type: "warning" }
			)
				.then(() => {
					this.attest();
				})
				.catch(e => console.log(e));
		},

		attest() {
			this.$axios.$post(`/api/task/attest/${this.task.id}`).then(response => {
				this.$message({
					message: response.message,
					type: "success",
					showClose: true
				});

				this.$emit("refresh");
			});
		},

		getData() {
			this.fetching = true;
			this.$axios
				.$get(`/api/task/document/${this.task.id}`)
				.then(response => {
					this.document = response;
				})
				.catch(e => {
					this.$message({
						message: e.response.data.message,
						type: "error",
						showClose: true
					});
				})
				.finally(() => (this.fetching = false));
		}
	},

	mounted() {
		this.getData();
	}
};
</script>
