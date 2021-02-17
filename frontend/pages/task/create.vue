<template>
	<div class="card">
		<div class="card-header bg-primary text-white">
			<i class="el-icon-plus"></i> NEW TASK
		</div>

		<div class="card-body row">
			<el-form label-position="left" label-width="120px" class="col-7">
				<el-form-item label="Title">
					<el-input v-model="model.title" placeholder="Title"></el-input>
				</el-form-item>
				<el-form-item label="Description">
					<el-input
						type="textarea"
						rows="7"
						v-model="model.description"
						placeholder="Title"
					></el-input>
				</el-form-item>
			</el-form>

			<div class="col-5">
				<div class="mb-3"><i class="uil-paperclip"></i> Attachments</div>
				<el-upload
					drag
					action="https://jsonplaceholder.typicode.com/posts/"
					multiple
				>
					<i class="el-icon-upload"></i>
					<div class="el-upload__text">
						Drop file here or <em>click to upload</em>
					</div>
				</el-upload>
			</div>
		</div>

		<div class="card-footer text-right">
			<el-button class="btn-secondary" icon="el-icon-close">CANCEL</el-button>
			<el-button class="btn-primary" icon="el-icon-check">SUBMIT</el-button>
		</div>
	</div>
</template>

<script>
import form from '@/mixins/form';

export default {
  mixins: [form],
  data() {
    return {
      url: '/api/task',
      model: {}
    }
  },
}
</script>

<style>
</style>
