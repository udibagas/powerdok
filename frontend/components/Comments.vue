<template>
	<div>
		<div class="media mb-3 pt-3" v-for="comment in comments" :key="comment.id">
			<el-avatar class="mr-3"></el-avatar>
			<div class="media-body">
				<div class="d-flex justify-content-between">
					<div>
						<strong>{{ comment.user.name }}</strong>
						<div class="text-muted">
							{{ comment.user.position }} |
							{{
								comment.user.department ? comment.user.department.name : "N/A"
							}}
						</div>
					</div>
					<small class="text-muted">
						{{ readableDateTime(comment.created_at) }}
					</small>
				</div>

				<div class="my-3">
					{{ comment.body }}
				</div>

				<el-button type="text">
					<i class="mdi mdi-reply mr-1"></i> {{ $t("Reply") }}
				</el-button>
			</div>
		</div>
	</div>
</template>

<script>
import moment from 'moment';

export default {
  props: ['comments'],

  methods: {
    readableDate(date) {
      return moment(date).format('DD-MMM-YYYY');
    },

    readableDateTime(date) {
      return moment(date).format('DD-MMM-YYYY HH:mm');
    }
  }
}
</script>

<style>
</style>
