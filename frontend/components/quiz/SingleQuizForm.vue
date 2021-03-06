<template>
	<div class="flex-grow-1">
		<div class="d-flex">
			<div class="mr-3 mb-3 flex-grow-1">
				<el-alert
					class="mb-3"
					type="error"
					title="Validation error"
					v-if="Object.values(errors).length > 0"
				>
					<ul>
						<template v-for="(error, i) in Object.entries(errors)">
							<li v-if="error[0] == `quizzes.${index}.question`" :key="i">
								{{ error[1].join(",") }}
							</li>
							<li v-if="error[0] == `quizzes.${index}.choices`" :key="i">
								{{ error[1].join(",") }}
							</li>
							<li v-if="error[0] == `quizzes.${index}.correct_answer`" :key="i">
								{{ error[1].join(",") }}
							</li>
						</template>
					</ul>
				</el-alert>

				<el-input
					type="textarea"
					rows="3"
					:placeholder="$t('Question')"
					v-model="quiz.question"
					class="mb-3"
				></el-input>

				<div class="d-flex flex-wrap mb-3">
					<el-upload
						action="#"
						list-type="picture-card"
						multiple
						:on-success="handleUploadFileSuccess"
						:on-error="handleUploadFileError"
						:http-request="upload"
						:file-list="fileList"
					>
						<i slot="default" class="el-icon-plus"></i>
						<div slot="file" slot-scope="{ file }">
							<img
								class="el-upload-list__item-thumbnail"
								:src="file.url"
								alt=""
							/>
							<span class="el-upload-list__item-actions">
								<span
									class="el-upload-list__item-preview"
									@click="handlePreview(file)"
								>
									<i class="el-icon-zoom-in"></i>
								</span>
								<span
									class="el-upload-list__item-delete"
									@click="handleRemove(file)"
								>
									<i class="el-icon-delete"></i>
								</span>
							</span>
						</div>
					</el-upload>
				</div>
			</div>
			<div>
				<el-button
					type="danger"
					size="small"
					circle
					icon="el-icon-delete"
					@click="$emit('delete', index, quiz.id)"
				></el-button>
			</div>
		</div>

		<div class="row">
			<div
				v-for="(c, i) in quiz.choices"
				:key="i"
				class="col-md-6 col-sm-12 mb-3 d-flex"
			>
				<el-radio v-model="quiz.correct_answer" :label="i">
					<h5 class="text-muted" style="display: inline-block">
						{{ ["A", "B", "C", "D"][i] }}.
					</h5>
				</el-radio>
				<el-input
					type="textarea"
					rows="2"
					v-model="quiz.choices[i]"
					:placeholder="$t('Choice')"
				></el-input>
			</div>
		</div>

		<vue-easy-lightbox
			:visible="previewImage"
			:imgs="quiz.attachments.map((a) => a.url)"
			:index="indexImage"
			@hide="
				previewImage = false;
				indexImage = 0;
			"
		></vue-easy-lightbox>
	</div>
</template>

<script>
export default {
	props: ["index", "quiz", "errors"],

	data() {
		return {
			disabled: false,
			previewImage: false,
			indexImage: 0,
			fileList: []
		};
	},

	mounted() {
		this.fileList = this.quiz.attachments.map(file => {
			const { id, name, url, path, user_id } = file;
			return { id, name, url, path, user_id };
		});
	},

	methods: {
		beforeUpload() {
			// TODO: check extension
		},

		upload(params) {
			const { file, onError, onSuccess, onProgress, data } = params;

			let formData = new FormData();
			formData.append("file", file);
			formData.append("data", JSON.stringify(data));

			this.$axios
				.$post("/api/upload", formData, {
					headers: { "Content-Type": "multipart/form-data" },
					onUploadProgress: e => {
						let percent = ((e.loaded / e.total) * 100) | 0;
						onProgress({ percent });
					}
				})
				.then(response => onSuccess(response))
				.catch(e => onError(e.response));
		},

		handlePreview(file) {
			this.indexImage = this.quiz.attachments.findIndex(a => a.url == file.url);
			this.previewImage = true;
		},

		handleRemove(file) {
			// console.log(file, this.fileList);
			this.fileList = this.fileList.filter(f => f.uid != file.uid);
			this.quiz.attachments = this.fileList.map(file => {
				const { name, path, url, user_id } = file;
				return { name, path, url, user_id };
			});
		},

		handleUploadFileSuccess(res, file, fileList) {
			this.$message({ message: res.message, type: "success" });

			if (this.quiz.attachments == null) {
				this.quiz.attachments = [];
			}

			const { name, path, user_id, url } = res;
			this.quiz.attachments.push({ name, path, user_id, url });
			this.$forceUpdate();
		},

		handleUploadFileError(err, file, fileList) {
			let message = "";

			if (err.status == 413) {
				message = this.$t("Failed to upload document. File too big.");
			}

			if (err.status == 422) {
				message = err.data.errors.file[0];
			}

			if (err.status == 500) {
				message = err.data.message;
			}

			this.$message({
				message: message,
				type: "error",
				showClose: true,
				duration: 10000
			});
		},

		handlePictureCardPreview(file) {
			this.dialogImageUrl = file.url;
			this.dialogVisible = true;
		},

		handleDownload(file) {
			console.log(file);
		}
	}
};
</script>
