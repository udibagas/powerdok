<template>
	<div>
		<div class="text-muted my-3">
			<i class="el-icon-paperclip"></i>
			{{ $t("Attachments") }}
		</div>

		<div class="row">
			<div
				class="col-md-4"
				v-for="(attachment, i) in attachments"
				:key="attachment.id"
			>
				<div class="media border rounded p-2 mb-3">
					<a
						href="#"
						@click.prevent="
							index = i;
							visible = true;
						"
					>
						<el-image
							fit="cover"
							class="mr-2 border rounded"
							style="height: 50px; width: 50px"
							:src="attachment.url"
						>
							<div
								slot="error"
								class="image-slot text-center"
								style="line-height: 50px"
							>
								<i
									class="el-icon-document"
									style="font-size: 30px; margin-top: 10px"
								></i>
							</div>
						</el-image>
					</a>
					<div class="media-body text-truncate">
						<div>{{ attachment.name }}</div>
						<div class="text-muted">
							{{ attachment.type }}
						</div>
						<div class="text-muted">
							{{ bytesToSize(attachment.size) }}
							<a href="#" class="ml-3" @click.prevent="download(attachment.id)">
								<i class="el-icon-download"></i>
							</a>
						</div>
					</div>
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
	props: ["attachments"],
	data() {
		return {
			index: 0,
			visible: false
		};
	},

	methods: {
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
