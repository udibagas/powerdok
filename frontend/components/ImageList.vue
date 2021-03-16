<template>
	<vue-easy-lightbox
		:visible="show"
		:imgs="images"
		:index="index"
		@hide="$emit('hide')"
	></vue-easy-lightbox>
</template>

<script>
export default {
	props: ["images", "show", "index"],

	methods: {
		hide() {
			this.index = 0;
		}
	}
};
</script>

<style>
</style>
