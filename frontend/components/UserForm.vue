<template>
	<el-dialog
		title="USER"
		width="500px"
		:visible.sync="show"
		:before-close="closeForm"
		:close-on-click-modal="false"
	>
		<el-form label-width="180px" label-position="left">
			<el-form-item label="Name" :class="{ 'is-error': errors.name }">
				<el-input
					size="small"
					v-model="formModel.name"
					placeholder="Name"
				></el-input>

				<div class="el-form-item__error" v-if="errors.name">
					{{ errors.name.join(', ') }}
				</div>
			</el-form-item>

      <el-form-item label="Email" :class="{ 'is-error': errors.email }">
				<el-input
					size="small"
					v-model="formModel.email"
					placeholder="Email"
				></el-input>

				<div class="el-form-item__error" v-if="errors.email">
					{{ errors.email.join(', ') }}
				</div>
			</el-form-item>

			<el-form-item label="Password" :class="{ 'is-error': errors.password }">
				<el-input
					type="password"
					size="small"
					v-model="formModel.password"
					placeholder="Password"
				></el-input>

				<div class="el-form-item__error" v-if="errors.password">
					{{ errors.password.join(', ') }}
				</div>
			</el-form-item>

			<el-form-item
				label="Password Confirmation"
				:class="{ 'is-error': errors.password_confirmation }"
			>
				<el-input
					type="password"
					size="small"
					v-model="formModel.password_confirmation"
					placeholder="Password"
				></el-input>

				<div class="el-form-item__error" v-if="errors.password_confirmation">
					{{ errors.password_confirmation.join(', ') }}
				</div>
			</el-form-item>
		</el-form>

		<div slot="footer">
			<el-button size="small" icon="el-icon-circle-close" @click="closeForm">
				CANCEL
			</el-button>

			<el-button
				size="small"
        class="btn-primary"
				icon="el-icon-success"
				@click="submit(model.id)"
				:loading="loading"
			>
				{{ formModel.id ? 'UPDATE' : 'SAVE' }}
			</el-button>
		</div>
	</el-dialog>
</template>

<script>
import form from '~/mixins/form'

export default {
	props: ['show', 'model', 'url'],
	mixins: [form],
	computed: {
		formModel() {
			return this.model
		},
	},
}
</script>
