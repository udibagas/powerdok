<script>
export default {
  middleware: ['auth'],
  created() {
    document.body.removeAttribute("data-layout");
    document.body.removeAttribute("data-topbar");
  },
  methods: {
    toggleRightSidebar() {
      document.body.classList.toggle("right-bar-enabled");
    },
    hideRightSidebar() {
      document.body.classList.remove("right-bar-enabled");
    },
    toggleMenu() {
      document.body.classList.toggle("sidebar-enable");

      if (window.screen.width >= 992) {
        // eslint-disable-next-line no-unused-vars
        this.$router.afterEach((routeTo, routeFrom) => {
          document.body.classList.remove("sidebar-enable");
          document.body.classList.remove("vertical-collpsed");
        });
        document.body.classList.toggle("vertical-collpsed");
      } else {
        // eslint-disable-next-line no-unused-vars
        this.$router.afterEach((routeTo, routeFrom) => {
            document.body.classList.remove("sidebar-enable");
        });
        document.body.classList.remove("vertical-collpsed");
      }
      this.isMenuCondensed = !this.isMenuCondensed;
    },
  },
  data() {
    return {};
  },
};
</script>

<template>
	<div id="layout-wrapper">
		<Topbar />
		<Sidebar type="dark" width="fluid" />
		<div class="main-content">
			<div class="page-content">
				<div class="container-fluid">
					<Nuxt />
				</div>
			</div>
			<!-- <Footer /> -->
		</div>
	</div>
</template>
