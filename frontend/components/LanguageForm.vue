<template>
	<el-dialog
		title="LANGUAGE"
		width="500px"
		:visible.sync="show"
		:before-close="closeForm"
		:close-on-click-modal="false"
	>
		<el-form label-width="180px" label-position="left">
      <el-form-item label="Locale">
				<el-select
					size="small"
					style="width: 100%"
					v-model="formModel.locale"
					placeholder="Locale"
					filterable
					default-first-option
				>
					<el-option value="en"></el-option>
					<el-option value="id"></el-option>
				</el-select>

        <div class="el-form-item__error" v-if="errors.locale">
					{{ errors.locale.join(', ') }}
				</div>
			</el-form-item>

      <el-form-item label="Key" :class="{ 'is-error': errors.key }">
				<el-input
					size="small"
					v-model="formModel.key"
					placeholder="Key"
				></el-input>

				<div class="el-form-item__error" v-if="errors.key">
					{{ errors.key.join(', ') }}
				</div>
			</el-form-item>

			<el-form-item label="Text" :class="{ 'is-error': errors.text }">
				<el-input
					size="small"
					v-model="formModel.text"
					placeholder="Text"
				></el-input>

				<div class="el-form-item__error" v-if="errors.text">
					{{ errors.text.join(', ') }}
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
