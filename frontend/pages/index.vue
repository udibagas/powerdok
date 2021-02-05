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
            title: "Starter Page",
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
</div>
</template>

<style></style>
