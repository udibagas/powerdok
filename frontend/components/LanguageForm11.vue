<template>
	<b-modal title="LANGUAGE" v-model="show">
		<b-form>
			<b-form-group label="Locale">
				<b-form-input
					v-model="model.locale"
					placeholder="Locale"
				></b-form-input>
			</b-form-group>

			<b-form-group label="Key">
				<b-form-textarea
					v-model="model.key"
					placeholder="key"
				></b-form-textarea>
			</b-form-group>

			<b-form-group label="Text">
				<b-form-textarea
					v-model="model.text"
					placeholder="text"
				></b-form-textarea>
			</b-form-group>
		</b-form>
	</b-modal>
</template>

<script>
import form from '~/mixins/form'

export default {
	props: ['show', 'model', 'url'],
	mixins: [form],
}
</script>
