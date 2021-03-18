<template>
	<div class="border rounded shadow p-3">
		<el-form class="mt-3">
			<el-form-item>
				<el-input
					v-model="form.body"
					type="textarea"
					:autosize="{ minRows: 2, maxRows: 10 }"
					placeholder="Type your comment here"
				></el-input>
			</el-form-item>
		</el-form>

		<div class="mb-3" v-if="form.attachments.length > 0">
			<div
				class="media p-2 rounded hover"
				v-for="(attachment, index) in form.attachments"
				:key="index"
			>
				<i class="el-icon-document mr-2" style="font-size: 40px"></i>
				<div class="media-body d-flex justify-content-between">
					<div>
						<a href="#" @click.prevent="download(attachment.url)">
							{{ attachment.name }}
						</a>
						<div class="text-muted">{{ bytesToSize(attachment.size) }}</div>
					</div>
					<div>
						<el-button
							icon="el-icon-delete"
							type="text"
							@click="removeAttachment(index, attachment.path)"
						></el-button>
					</div>
				</div>
			</div>
		</div>

		<div>
			<el-button size="small" type="primary" @click="save">
				<i class="uil-comment-dots mr-1"></i> {{ $t("COMMENT") }}
			</el-button>

			<el-button type="text" icon="el-icon-paperclip" @click="attach">
				{{ $t("Attach Document") }}
			</el-button>
		</div>
	</div>
</template>

<script>
export default {
	props: ["url"],

	data() {
		return {
			form: { attachments: [] },
			errors: {}
		};
	},

	methods: {
		save() {
			this.$axios
				.$post(this.url, this.form)
				.then(response => {
					this.$message({
						message: response.message,
						type: "success",
						showClose: true
					});

					this.form = { attachments: [] };
					this.errors = {};
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
		},

		attach() {
			let el = document.createElement("input");
			el.type = "file";
			el.style = "display: none";

			el.addEventListener("change", event => {
				let formData = new FormData();
				formData.append("file", event.target.files[0]);

				this.$axios
					.$post("api/upload", formData, {
						headers: { "Content-Type": "multipart/form-data" }
					})
					.then(response => {
						this.form.attachments.push(response);
					})
					.catch(e => {
						this.$message({
							message: e.response.data.message,
							type: "error",
							showClose: true
						});
					});
			});

			el.click();
			el.remove();
		},

		removeAttachment(index, path) {
			this.$axios
				.$delete("/api/attachment/deleteByPath", { params: { path } })
				.then(response => {
					this.form.attachments.splice(index, 1);
				})
				.catch(e => {
					this.$message({
						message: e.response.data.message,
						type: "error",
						showClose: true
					});
				});
		},

		bytesToSize(bytes) {
			var sizes = ["Bytes", "KB", "MB", "GB", "TB"];
			if (bytes == 0) return "0 Byte";
			var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
			return Math.round(bytes / Math.pow(1024, i), 2) + " " + sizes[i];
		},

		download(url) {
			window.open(url, "_blank");
		}
	}
};
</script>

<style scoped>
.hover:hover {
	background: #eee;
}
</style>
