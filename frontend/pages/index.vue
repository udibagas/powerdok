<script>
/**
 * Dashboard component
 */
export default {
  head() {
    return {
      title: `${this.title}`,
    };
  },

  data() {
    return {
      title: "Powerdok | Dashboard",
      items: [{
          text: "Menu",
        },
        {
          text: "Dashboard",
          active: true,
        },
      ],
    };
  },
};
</script>

<template>
	<div>
		<PageHeader :title="title" :items="items" />
		<Activity />
	</div>
</template>

<style></style>
