<template>
	<app-layout>
		<div class="bg-white rounded-md m-3 p-3">
			<div class="flex border-b py-3">
				<div class="flex-grow text-2xl font-bold text-purple-700">Users</div>
				<div class="text-right">
					<button
						class="px-3 mr-3 py-1 border rounded-md border-purple-900 text-purple-900 hover:bg-purple-900 hover:text-white"
					>
						+ NEW USER
					</button>

					<input
						type="text"
						class="border rounded-md px-3 py-1"
						placeholder="Search"
					/>
				</div>
			</div>
			<table class="min-w-full">
				<thead>
					<tr>
						<th class="border-b px-3 py-2 w-10">No.</th>
						<th class="border-b px-3 py-2">Name</th>
						<th class="border-b px-3 py-2">Email</th>
					</tr>
				</thead>
				<tbody>
					<tr v-for="(user, index) in users.data" :key="user.id">
						<td class="border-b px-3 py-2">{{ users.from + index }}</td>
						<td class="border-b px-3 py-2">{{ user.name }}</td>
						<td class="border-b px-3 py-2">{{ user.email }}</td>
					</tr>
				</tbody>
			</table>

			<div class="my-3 flex">
				<div class="flex-grow">
					<inertia-link
						:class="{
							'bg-purple-700 text-white': p.active,
							'text-purple-700': !p.active,
						}"
						class="px-2 py-0 mr-2 border rounded border-purple-700"
						v-for="(p, i) in users.links"
						:href="p.url"
						:key="i"
						v-html="p.label"
					></inertia-link>
				</div>
				<div>
					<select name="" id="">
						<option value="15">15</option>
						<option value="25">25</option>
						<option value="50">50</option>
						<option value="100">100</option>
					</select>
					Showing {{ users.from }} - {{ users.to }} of {{ users.total }}
				</div>
			</div>
		</div>

		<jet-confirmation-modal
			:show="confirmingUserDeletion"
			@close="confirmingUserDeletion = false"
		>
			<template #title> Delete Account </template>

			<template #content>
				Are you sure you want to delete this user? Once this user is deleted,
				all of its resources and data will be permanently deleted.
			</template>

			<template #footer>
				<jet-secondary-button @click.native="confirmingUserDeletion = false">
					Cancel
				</jet-secondary-button>

				<jet-danger-button
					class="ml-2"
					@click.native="deleteUser"
					:class="{ 'opacity-25': form.processing }"
					:disabled="form.processing"
				>
					Delete User
				</jet-danger-button>
			</template>
		</jet-confirmation-modal>
	</app-layout>
</template>

<script>
import AppLayout from "../Layouts/AppLayout";

export default {
	components: { AppLayout },
	props: ["users"],

	data() {
		return {
			confirmingUserDeletion: false
		};
	},

	methods: {
		deleteUser() {
			// this.inertia.form.de
		}
	}
};
</script>
