<template>
	<el-dialog
		title="USER"
		:visible.sync="show"
		:before-close="closeForm"
		:close-on-click-modal="false"
	>
		<el-form label-width="200px" label-position="left">
			<el-form-item label="Name" :class="{ 'is-error': errors.name }">
				<el-input v-model="formModel.name" placeholder="Name"></el-input>

				<div class="el-form-item__error" v-if="errors.name">
					{{ errors.name.join(", ") }}
				</div>
			</el-form-item>

			<el-form-item label="Email" :class="{ 'is-error': errors.email }">
				<el-input v-model="formModel.email" placeholder="Email"></el-input>

				<div class="el-form-item__error" v-if="errors.email">
					{{ errors.email.join(", ") }}
				</div>
			</el-form-item>

			<el-form-item label="Position" :class="{ 'is-error': errors.position }">
				<el-input
					v-model="formModel.position"
					placeholder="Position"
				></el-input>

				<div class="el-form-item__error" v-if="errors.position">
					{{ errors.position.join(", ") }}
				</div>
			</el-form-item>

			<el-form-item label="Department">
				<el-select
					style="width: 100%"
					v-model="formModel.department_id"
					placeholder="Department"
					filterable
					default-first-option
					clearable
					remote
					:remote-method="
						(q) => getList('/api/department', 'departmentList', q)
					"
				>
					<el-option
						v-for="department in departmentList"
						:key="department.id"
						:value="department.id"
						:label="department.name"
					></el-option>
				</el-select>

				<div class="el-form-item__error" v-if="errors.department_id">
					{{ errors.department_id.join(", ") }}
				</div>
			</el-form-item>

			<el-form-item label="Password" :class="{ 'is-error': errors.password }">
				<el-input
					type="password"
					v-model="formModel.password"
					placeholder="Password"
				></el-input>

				<div class="el-form-item__error" v-if="errors.password">
					{{ errors.password.join(", ") }}
				</div>
			</el-form-item>

			<el-form-item
				label="Password Confirmation"
				:class="{ 'is-error': errors.password_confirmation }"
			>
				<el-input
					type="password"
					v-model="formModel.password_confirmation"
					placeholder="Password"
				></el-input>

				<div class="el-form-item__error" v-if="errors.password_confirmation">
					{{ errors.password_confirmation.join(", ") }}
				</div>
			</el-form-item>
		</el-form>

		<div slot="footer">
			<el-button icon="el-icon-circle-close" @click="closeForm">
				CANCEL
			</el-button>

			<el-button
				class="btn-primary"
				icon="el-icon-success"
				@click="submit(model.id)"
				:loading="loading"
			>
				{{ formModel.id ? "UPDATE" : "SAVE" }}
			</el-button>
		</div>
	</el-dialog>
</template>

<script>
import form from '~/mixins/form'
import dropdown from '~/mixins/dropdown'

export default {
	props: ['show', 'model', 'url'],
	mixins: [form, dropdown],
	computed: {
		formModel() {
			return this.model
		},
	},
  mounted() {
		this.getList('/api/department', 'departmentList')
  }
}
</script>
