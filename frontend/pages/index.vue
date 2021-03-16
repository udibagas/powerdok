<template>
	<div class="row">
		<!-- <PageHeader :title="title" :items="items" /> -->
		<div class="col">
			<el-card>
				<div class="text-muted">Task</div>
			</el-card>
		</div>
	</div>
</template>

<script>
export default {
	head() {
		return {
			title: `${this.title}`
		};
	},

	data() {
		return {
			title: "Powerdok | Dashboard",
			items: [
				{
					text: "Menu"
				},
				{
					text: "Dashboard",
					active: true
				}
			]
		};
	}
};
</script>
