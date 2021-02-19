<template>
	<div class="card">
		<div class="card-header bg-primary text-white">
			<i class="el-icon-plus"></i> NEW TASK
		</div>

		<div class="card-body row">
			<el-form label-position="left" label-width="120px" class="col-7">
				<el-form-item label="Title">
					<el-input v-model="model.title" placeholder="Title"></el-input>

					<div class="el-form-item__error" v-if="errors.title">
						{{ errors.title.join(", ") }}
					</div>
				</el-form-item>

				<el-form-item label="Description">
					<el-input
						type="textarea"
						rows="7"
						v-model="model.description"
						placeholder="Description"
					></el-input>

					<div class="el-form-item__error" v-if="errors.description">
						{{ errors.description.join(", ") }}
					</div>
				</el-form-item>

				<el-form-item :label="$t('Type')">
					<el-select
						style="width: 100%"
						v-model="model.type"
						:placeholder="$t('Type')"
						default-first-option
					>
						<el-option :value="1" :label="$t('Document Review')"></el-option>
						<el-option :value="2" :label="$t('Atestation')"></el-option>
						<el-option :value="3" :label="$t('Examination')"></el-option>
					</el-select>

					<div class="el-form-item__error" v-if="errors.type">
						{{ errors.type.join(", ") }}
					</div>
				</el-form-item>

				<el-form-item label="Assignees">
					<el-select
						style="width: 100%"
						v-model="model.assignees"
						placeholder="Assignees"
						filterable
						default-first-option
						clearable
						remote
						multiple
						:remote-method="(q) => getList('/api/user', 'userList', q)"
					>
						<el-option
							v-for="user in userList"
							:key="user.id"
							:value="user.id"
							:label="`${user.name} | ${user.position ? user.position : ''}  (${
								user.department_id ? user.department.name : 'N/A'
							})`"
						>
							<span style="float: left">{{ user.name }}</span>
							<span
								style="
									float: right;
									color: #8492a6;
									font-size: 13px;
									margin-right: 20px;
								"
							>
								{{ user.position }} ({{
									user.department_id ? user.department.name : "N/A"
								}})
							</span>
						</el-option>
					</el-select>

					<div class="el-form-item__error" v-if="errors.assignees">
						{{ errors.assignees.join(", ") }}
					</div>
				</el-form-item>

				<el-form-item label="Due Date" :class="{ 'is-error': errors.due_date }">
					<el-date-picker
						style="width: 100%"
						v-model="model.due_date"
						type="date"
						format="dd-MMM-yyyy"
						value-format="yyyy-MM-dd"
						placeholder="Due Date"
					></el-date-picker>

					<div class="el-form-item__error" v-if="errors.due_date">
						{{ errors.due_date.join(", ") }}
					</div>
				</el-form-item>

				<el-form-item label="Priority">
					<el-select
						style="width: 100%"
						v-model="model.priority"
						placeholder="Priority"
						filterable
						clearable
						default-first-option
					>
						<el-option :value="0" label="Low"></el-option>
						<el-option :value="1" label="Medium"></el-option>
						<el-option :value="2" label="High"></el-option>
						<el-option :value="3" label="Urgent"></el-option>
					</el-select>

					<div class="el-form-item__error" v-if="errors.priority">
						{{ errors.priority.join(", ") }}
					</div>
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
			<el-button
				size="small"
				icon="el-icon-circle-close"
				@click.native="$router.push('/task')"
			>
				CANCEL
			</el-button>

			<el-button
				size="small"
				class="btn-primary"
				icon="el-icon-success"
				@click="submit(model.id)"
				:loading="loading"
				>SAVE
			</el-button>
		</div>
	</div>
</template>

<script>
import form from '@/mixins/form'
import dropdown from '~/mixins/dropdown'

export default {
  mixins: [form, dropdown],
  head() {
    return {
      title: `${this.title}`,
    };
  },
  data() {
    return {
      url: '/api/task',
      model: {},
      title: "Powerdok | New Task "
    }
  },

  methods: {
    closeForm(data) {
      this.errors = {}
      this.$router.push(`/task/${data.data.id}`);
    }
  }
}
</script>

<style>
</style>
