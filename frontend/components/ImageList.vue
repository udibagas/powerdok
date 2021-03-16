<template>
	<div>
		<div class="d-flex">
			<a
				v-for="(url, i) in images"
				:key="i"
				href="#"
				@click.prevent="
					index = i;
					visible = true;
				"
			>
				<el-image
					class="my-3 border mr-3 rounded"
					style="height: 100px; width: 100px"
					:src="url"
				></el-image>
			</a>
		</div>
		<vue-easy-lightbox
			:visible="visible"
			:imgs="images"
			:index="index"
			@hide="hide"
		></vue-easy-lightbox>
	</div>
</template>

<script>
export default {
	props: ["images", "show"],

	data() {
		return {
			index: 0,
			visible: false
		};
	},

	methods: {
		hide() {
			this.index = 0;
			this.visible = false;
		}
	}
};
</script>

<style>
</style>
