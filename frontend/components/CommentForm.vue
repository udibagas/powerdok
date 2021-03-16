<template>
	<div class="media border shadow p-3">
		<el-avatar class="mr-3" :size="45" icon="el-icon-user"></el-avatar>
		<div class="media-body">
			<strong>{{ $t("Me") }}</strong>

			<div class="text-muted">
				{{ $auth.user.position }} |
				{{ $auth.user.department ? $auth.user.department.name : "N/A" }}
			</div>

			<el-form class="mt-3">
				<el-form-item>
					<el-input
						v-model="form.body"
						type="textarea"
						:autosize="{ minRows: 2, maxRows: 10 }"
						placeholder="Type your comment here"
					></el-input>
				</el-form-item>

				<!-- <el-form-item label="Due Date" :class="{ 'is-error': errors.due_date }">
				<el-date-picker
					style="width: 100%"
					v-model="form.due_date"
					type="date"
					format="dd-MMM-yyyy"
					value-format="yyyy-MM-dd"
					placeholder="Due Date"
				></el-date-picker>

				<div class="el-form-item__error" v-if="errors.due_date">
					{{ errors.due_date.join(", ") }}
				</div>
			</el-form-item> -->

				<!-- <el-form-item label="Priority">
				<el-select
					style="width: 100%"
					v-model="form.priority"
					placeholder="Priority"
					filterable
					clearable
					default-first-option
				>
					<el-option :value="0" label="Low"></el-option>
					<el-option :value="1" label="Medium"></el-option>
					<el-option :value="2" label="High"></el-option>
					<el-option :value="3" label="Urgent"></el-option>
				</el-select>

				<div class="el-form-item__error" v-if="errors.priority">
					{{ errors.priority.join(", ") }}
				</div>
			</el-form-item> -->
			</el-form>

			<div
				class="media mb-3"
				v-for="attachment in form.attachments"
				:key="attachment.id"
			>
				<i class="el-icon-document mr-2" style="font-size: 40px"></i>
				<div class="media-body">
					<a href="#" @click.prevent="download(attachment.url)">
						{{ attachment.name }}
					</a>
					<div class="text-muted">{{ bytesToSize(attachment.size) }}</div>
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

					this.form = {};
					this.errors = {};
					this.$emit("refresh", response.task);
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
