<template>
	<el-dialog
		title="LANGUAGE"
		width="700px"
		:visible.sync="show"
		:before-close="closeForm"
		:close-on-click-modal="false"
	>
		<el-form label-width="100px" label-position="left">
			<el-form-item label="Locale" :class="{ 'is-error': errors.key }">
				<el-select
					style="width: 100%"
					v-model="model.locale"
					placeholder="Locale"
				>
					<el-option
						v-for="lang in $i18n.locales"
						:key="lang.code"
						:value="lang.code"
						:label="lang.name"
					>
						<img :src="lang.flag" class="mr-1 border" height="12" />
						<span class="align-middle">{{ lang.name }}</span>
					</el-option>
				</el-select>

				<div class="el-form-item__error" v-if="errors.locale">
					{{ errors.locale.join(", ") }}
				</div>
			</el-form-item>

			<el-form-item label="Key" :class="{ 'is-error': errors.key }">
				<el-input
					type="textarea"
					rows="3"
					v-model="model.key"
					placeholder="Key"
				></el-input>

				<div class="el-form-item__error" v-if="errors.key">
					{{ errors.key.join(", ") }}
				</div>
			</el-form-item>

			<el-form-item label="Text" :class="{ 'is-error': errors.text }">
				<el-input
					type="textarea"
					rows="3"
					v-model="model.text"
					placeholder="Text"
				></el-input>

				<div class="el-form-item__error" v-if="errors.text">
					{{ errors.text.join(", ") }}
				</div>
			</el-form-item>
		</el-form>

		<div slot="footer">
			<el-button size="small" icon="el-icon-circle-close" @click="closeForm">
				CANCEL
			</el-button>

			<el-button
				class="btn-primary"
				icon="el-icon-success"
				@click="submit(model.id)"
				:loading="loading"
			>
				{{ model.id ? "UPDATE" : "SAVE" }}
			</el-button>
		</div>
	</el-dialog>
</template>

<script>
import form from '~/mixins/form'

export default {
	props: ['show', 'model', 'url'],
	mixins: [form],
}
</script>
