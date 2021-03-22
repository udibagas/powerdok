<template>
	<el-card shadhow="never" class="my-3" :header="$t('COMMENTS')">
		<CommentForm class="mb-3 bg-white" :url="url" @refresh="fetchData" />

		<content-placeholders v-if="fetching">
			<content-placeholders-heading :img="true" />
			<!-- <content-placeholders-text :lines="3" /> -->
		</content-placeholders>
		<div
			v-else
			class="media mb-3 pt-3 border-top"
			v-for="comment in comments"
			:key="comment.id"
		>
			<el-avatar class="mr-3" :size="45" icon="el-icon-user"></el-avatar>
			<div class="media-body">
				<strong>{{ comment.user.name }}</strong>

				<span class="text-muted">
					&bull;
					{{ comment.user.position }} |
					{{ comment.user.department ? comment.user.department.name : "N/A" }}
					<br />
					<i>
						{{ $moment(comment.created_at).lang($i18n.locale).fromNow() }}
					</i>
				</span>

				<div class="my-2" v-html="comment.body"></div>

				<Attachments
					v-if="comment.attachments.length > 0"
					class="mt-5"
					:data="comment.attachments"
				/>

				<!-- <el-input
					class="my-3"
					v-model="body"
					type="textarea"
					rows="3"
					placeholder="Reply"
				></el-input>

				<div>
					<el-button size="small" type="primary" @click="save">
						<i class="uil-comment-dots mr-1"></i> {{ $t("COMMENT") }}
					</el-button>
					<el-button size="small" type="info" icon="el-icon-paperclip">
						{{ $t("ATTACH") }}
					</el-button>
					<el-button size="small" type="danger" icon="el-icon-close">
						{{ $t("CANCEL") }}
					</el-button>
				</div>

				<el-button type="text">
					<i class="mdi mdi-reply mr-1"></i> {{ $t("Reply") }}
				</el-button> -->
			</div>
		</div>
	</el-card>
</template>

<script>
export default {
	props: ["url"],

	mounted() {
		this.fetchData();
	},

	data() {
		return {
			comments: [],
			fetching: true,
			body: ""
		};
	},

	methods: {
		fetchData() {
			this.$axios
				.$get(this.url)
				.then(response => (this.comments = response))
				.catch(e => {
					this.$message({
						message: e.response.data.message,
						type: "error",
						showClose: true
					});
				})
				.finally(() => (this.fetching = false));
		}
	}
};
</script>
