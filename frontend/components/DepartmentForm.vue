<template>
	<el-dialog
		title="DEPARTMENT"
		width="500px"
		:visible.sync="show"
		:before-close="closeForm"
		:close-on-click-modal="false"
	>
		<el-form label-width="180px" label-position="left">
      <el-form-item
      label="Name"
      :class="{ 'is-error': errors.name }"
      >
				<el-input
					v-model="formModel.name"
					placeholder="Name"
				></el-input>

				<div class="el-form-item__error" v-if="errors.name">
					{{ errors.name.join(', ') }}
				</div>
			</el-form-item>

      <el-form-item label="Description" :class="{ 'is-error': errors.description }">
				<el-input
          type="textarea"
          rows="3"
					v-model="formModel.description"
					placeholder="Description"
				></el-input>

				<div class="el-form-item__error" v-if="errors.description">
					{{ errors.description.join(', ') }}
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
