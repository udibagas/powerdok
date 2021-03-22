<template>
	<div>
		<div class="text-muted mb-3">
			<i class="el-icon-paperclip"></i>
			{{ $t("Attachments") }}
		</div>

		<div
			v-for="(attachment, i) in attachments"
			:key="attachment.id"
			class="media mb-2"
		>
			<a
				v-if="attachment.is_image"
				href="#"
				class="mr-2"
				@click.prevent="
					index = i;
					visible = true;
				"
			>
				<el-image
					fit="cover"
					class="mr-2 border rounded"
					style="height: 40px; width: 35px"
					:src="attachment.url"
				>
				</el-image>
			</a>
			<i v-else class="el-icon-document mr-2" style="font-size: 40px"></i>

			<div class="media-body">
				<a href="#" @click.prevent="download(attachment.id)">
					{{ attachment.name }}
				</a>
				<div class="text-muted">
					{{ bytesToSize(attachment.size) }}
				</div>
			</div>
		</div>

		<vue-easy-lightbox
			:visible="visible"
			:imgs="attachments.filter((a) => a.is_image).map((a) => a.url)"
			:index="index"
			@hide="visible = false"
		></vue-easy-lightbox>
	</div>
</template>

<script>
export default {
	props: ["url", "data"],

	data() {
		return {
			index: 0,
			visible: false,
			attachments: []
		};
	},

	mounted() {
		if (this.url) {
			this.fetchData();
		}

		if (this.data) {
			this.attachments = this.data;
		}
	},

	methods: {
		fetchData() {
			this.$axios
				.$get(this.url)
				.then(response => (this.attachments = response))
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

		download(id) {
			window.open(
				`${this.$axios.defaults.baseURL}/api/download/${id}`,
				"_blank"
			);
		}
	}
};
</script>
