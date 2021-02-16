<template>
	<div class="card">
		<div class="card-header">{{ task.title }}</div>
		<div class="card-body d-flex">
			<div class="border">
				{{ task.description }}
			</div>
			<div style="width: 300px">summary task di sini</div>
		</div>
	</div>
</template>

<script>
export default {
  async asyncData({$axios, params}) {
    const task = await $axios.$get(`/api/task/${params.id}`);
    return { task };
  }
}
</script>

<style>
</style>
