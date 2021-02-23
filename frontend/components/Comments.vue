<template>
	<div>
		<div class="media mb-5" v-for="comment in comments" :key="comment.id">
			<el-avatar
				src="https://ckeditor.com/docs/ckeditor5/latest/assets/img/m_1.jpg"
				class="mr-3"
				:size="40"
			></el-avatar>
			<div class="media-body">
				<strong>{{ comment.user.name }}</strong>

				<span class="text-muted">
					&bull;
					{{ comment.user.position }} |
					{{ comment.user.department ? comment.user.department.name : "N/A" }}
					&bull;
					{{ $moment(comment.created_at).lang($i18n.locale).fromNow() }}
				</span>
				<span class="badge badge-success">Online</span>

				<div class="mb-2">
					{{ comment.body }}
				</div>

				<!-- <el-button type="text">
					<i class="mdi mdi-reply mr-1"></i> {{ $t("Reply") }}
				</el-button> -->
			</div>
		</div>
	</div>
</template>

<script>
export default {
  props: ['comments'],
}
</script>

<style>
</style>
