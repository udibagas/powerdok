<script>
import { authFackMethods } from "~/store/helpers";
import moment from 'moment';

export default {
  data() {
    return {
      current_language: this.$i18n.locale,
      text: null,
      flag: null,
      value: null,
      notifications: []
    };
  },

  computed: {
    languages() {
      return this.$i18n.locales.map(({flag, code: language, name: title}) => {
        return {flag, language, title};
      })
    }
  },

  mounted() {
    this.value = this.languages.find((x) => x.language === this.$i18n.locale);
    this.text = this.value.title;
    this.flag = this.value.flag;
    this.getNewNotifications();
    setInterval(this.getNewNotifications, 5000);
  },

  methods: {
    ...authFackMethods,

    getNewNotifications() {
      this.$axios.$get('/api/notification/getNewNotifications').then(response => {
        if (response.length > this.notifications.length) {
          this.$notify.warning({
            position: "bottom-right",
            title: response[0].data.title,
            dangerouslyUseHTMLString: true,
            onClick: () => {
              this.readNotification(response[0]);
            },
            message: response[0].data.text + '<br /><small class="text-muted"><i class="mdi mdi-clock-outline"></i>' + this.readableTime(response[0].created_at) + '</small>'
          });
        }
        this.notifications = response;
      });
    },

    readNotification(notification) {
      this.$axios.$put(`/api/notification/markAsRead/${notification.id}`).then(response => {
        let index = this.notifications.findIndex(n => n.id == notification.id);
        this.notifications.splice(index, 1);
        this.$router.push(notification.data.url);
      });
    },

    markAllAsRead() {
      this.$axios.$put(`/api/notification/markAllAsRead`).then(response => {
        this.notifications = []
      });
    },

    readableTime(time) {
      return moment(time).format('DD-MMM-YY HH:mm');
    },

    toggleMenu() {
      this.$parent.toggleMenu();
    },

    initFullScreen() {
        document.body.classList.toggle("fullscreen-enable");
        if (
          !document.fullscreenElement &&
          /* alternative standard method */
          !document.mozFullScreenElement &&
          !document.webkitFullscreenElement
        ) {
          // current working methods
          if (document.documentElement.requestFullscreen) {
              document.documentElement.requestFullscreen();
          } else if (document.documentElement.mozRequestFullScreen) {
              document.documentElement.mozRequestFullScreen();
          } else if (document.documentElement.webkitRequestFullscreen) {
              document.documentElement.webkitRequestFullscreen(
                  Element.ALLOW_KEYBOARD_INPUT
              );
          }
        } else {
          if (document.cancelFullScreen) {
            document.cancelFullScreen();
          } else if (document.mozCancelFullScreen) {
            document.mozCancelFullScreen();
          } else if (document.webkitCancelFullScreen) {
            document.webkitCancelFullScreen();
          }
        }
    },

    setLanguage(locale, country, flag) {
      this.$i18n.setLocale(locale);
      this.$i18n.locale = locale;
      this.current_language = locale;
      this.text = country;
      this.flag = flag;
    },

    logoutUser() {
      this.$auth.logout();
      this.$router.push({ path: "/login", });
    },
  },
};
</script>

<template>
	<header id="page-topbar">
		<div class="navbar-header">
			<div class="d-flex">
				<!-- LOGO -->
				<div class="navbar-brand-box">
					<nuxt-link to="/" class="logo logo-dark">
						<span class="logo-sm">
							<img src="~/assets/images/logo-sm.png" alt height="22" />
						</span>
						<span class="logo-lg">
							<img src="~/assets/images/logo-dark.png" alt height="20" />
						</span>
					</nuxt-link>

					<nuxt-link to="/" class="logo logo-light">
						<span class="logo-sm">
							<img src="~/assets/images/logo-sm.png" alt height="22" />
						</span>
						<span class="logo-lg">
							<img src="~/assets/images/logo-light.png" alt height="20" />
						</span>
					</nuxt-link>
				</div>

				<button
					@click="toggleMenu"
					type="button"
					class="btn btn-sm px-3 font-size-16 header-item vertical-menu-btn"
					id="vertical-menu-btn"
				>
					<i class="fa fa-fw fa-bars"></i>
				</button>

				<!-- App Search-->
				<form class="app-search d-none d-lg-block">
					<div class="position-relative">
						<input
							type="text"
							class="form-control"
							:placeholder="$t('Search')"
						/>
						<span class="uil-search"></span>
					</div>
				</form>
			</div>

			<div class="d-flex">
				<b-dropdown
					variant="white"
					class="d-inline-block d-lg-none ml-2"
					toggle-class="header-item noti-icon"
					right
					menu-class="dropdown-menu-lg p-0"
				>
					<template v-slot:button-content>
						<i class="uil-search"></i>
					</template>
					<form class="p-3">
						<div class="form-group m-0">
							<div class="input-group">
								<input
									type="text"
									class="form-control"
									:placeholder="$t('navbar.search.text')"
									aria-label="Recipient's username"
								/>
								<div class="input-group-append">
									<button class="btn btn-primary" type="submit">
										<i class="mdi mdi-magnify"></i>
									</button>
								</div>
							</div>
						</div>
					</form>
				</b-dropdown>

				<b-dropdown variant="white" right toggle-class="header-item">
					<template v-slot:button-content>
						<img class="border" :src="flag" alt="Header Language" height="16" />
						{{ text }}
					</template>
					<b-dropdown-item
						class="notify-item"
						v-for="(entry, i) in languages"
						:key="`Lang${i}`"
						:value="entry"
						@click="setLanguage(entry.language, entry.title, entry.flag)"
						:link-class="{ active: entry.language === current_language }"
					>
						<img
							:src="`${entry.flag}`"
							alt="user-image"
							class="mr-1 border"
							height="12"
						/>
						<span class="align-middle">{{ entry.title }}</span>
					</b-dropdown-item>
				</b-dropdown>

				<div class="dropdown d-none d-lg-inline-block ml-1">
					<button
						type="button"
						class="btn header-item noti-icon waves-effect"
						data-toggle="fullscreen"
						@click="initFullScreen"
					>
						<i class="uil-minus-path"></i>
					</button>
				</div>

				<b-dropdown
					variant="white"
					class="dropdown d-inline-block"
					toggle-class="header-item noti-icon"
					right
					menu-class="dropdown-menu-lg p-0"
				>
					<template v-slot:button-content>
						<i class="uil-bell"></i>
						<span class="badge badge-danger badge-pill">{{
							notifications.length
						}}</span>
					</template>

					<div class="p-3" v-if="notifications.length > 0">
						<div class="row align-items-center">
							<div class="col">
								<h5 class="m-0 font-size-16">
									{{ $t("Notifications") }}
								</h5>
							</div>
							<div class="col-auto">
								<a href="#!" @click.prevent="markAllAsRead" class="small">{{
									$t("Mark all as read")
								}}</a>
							</div>
						</div>
					</div>
					<div class="text-center p-3" v-if="notifications.length == 0">
						{{ $t("No new notification") }}
					</div>
					<simplebar
						v-if="notifications.length > 0"
						style="max-height: 230px"
						data-simplebar
					>
						<a
							href
							class="text-reset notification-item"
							v-for="notification in notifications"
							:key="notification.id"
							:to="notification.data.url"
							@click.prevent="readNotification(notification)"
						>
							<div class="media">
								<div class="avatar-xs mr-3">
									<span
										class="avatar-title bg-primary rounded-circle font-size-16"
									>
										<i
											class="uil-file-question-alt"
											v-if="notification.data.type == 'task'"
										></i>
										<i
											class="uil-comment-dots"
											v-if="notification.data.type == 'comment'"
										></i>
									</span>
								</div>

								<!-- <img
									src="~/assets/images/users/avatar-4.jpg"
									class="mr-3 rounded-circle avatar-xs"
									alt="user-pic"
								/> -->
								<div class="media-body">
									<h6 class="mt-0 mb-1">
										{{ notification.data.title }}
									</h6>
									<div class="font-size-12 text-muted">
										<p class="mb-1">
											{{ notification.data.text }}
										</p>
										<p class="mb-0">
											<i class="mdi mdi-clock-outline"></i>
											{{ readableTime(notification.created_at) }}
										</p>
									</div>
								</div>
							</div>
						</a>
					</simplebar>
					<div class="p-2 border-top">
						<nuxt-link
							to="/notification"
							class="btn btn-sm btn-link font-size-14 btn-block text-center"
							href="javascript:void(0)"
						>
							<i class="uil-arrow-circle-right mr-1"></i>
							{{ $t("Show all notifications") }}
						</nuxt-link>
					</div>
				</b-dropdown>

				<b-dropdown
					class="d-inline-block"
					toggle-class="header-item"
					right
					variant="white"
				>
					<template v-slot:button-content>
						<img
							class="rounded-circle header-profile-user"
							src="~/assets/images/users/avatar-4.jpg"
							alt="Header Avatar"
						/>
						<span
							class="d-none d-xl-inline-block ml-1 font-weight-medium font-size-15"
							>{{ $auth.user.name }}</span
						>
						<i class="uil-angle-down d-none d-xl-inline-block font-size-15"></i>
					</template>

					<!-- item-->
					<nuxt-link class="dropdown-item" to="/profile">
						<i
							class="uil uil-user-circle font-size-18 align-middle text-muted mr-1"
						></i>
						<span class="align-middle">{{ $t("Profile") }}</span>
					</nuxt-link>
					<a class="dropdown-item" href="#">
						<i
							class="uil uil-wallet font-size-18 align-middle mr-1 text-muted"
						></i>
						<span class="align-middle">{{ $t("My Task") }}</span>
						<span class="badge badge-soft-success badge-pill mt-1 ml-2"
							>03</span
						>
					</a>
					<a class="dropdown-item d-block" href="#">
						<i
							class="uil uil-cog font-size-18 align-middle mr-1 text-muted"
						></i>
						<span class="align-middle">{{ $t("Setting") }}</span>
					</a>
					<a class="dropdown-item" href="#">
						<i
							class="uil uil-lock-alt font-size-18 align-middle mr-1 text-muted"
						></i>
						<span class="align-middle">{{ $t("Lock Screen") }}</span>
					</a>
					<a
						class="dropdown-item"
						@click="logoutUser"
						href="javascript: void(0);"
					>
						<i
							class="uil uil-sign-out-alt font-size-18 align-middle mr-1 text-muted"
						></i>
						<span class="align-middle">{{ $t("Logout") }}</span>
					</a>
				</b-dropdown>
			</div>
		</div>
	</header>
</template>
