<template>
	<el-dialog
		title="TASK"
		width="85%"
		:visible.sync="show"
		:before-close="closeForm"
		:close-on-click-modal="false"
	>
		<div class="card-body row">
			<el-form label-position="left" label-width="120px" class="col-7">
				<el-form-item label="Title" :class="{ 'is-error': errors.title }">
					<el-input v-model="formModel.title" placeholder="Title"></el-input>

					<div class="el-form-item__error" v-if="errors.title">
						{{ errors.title.join(", ") }}
					</div>
				</el-form-item>

				<el-form-item
					label="Description"
					:class="{ 'is-error': errors.description }"
				>
					<el-input
						type="textarea"
						rows="7"
						v-model="formModel.description"
						placeholder="Description"
					></el-input>

					<div class="el-form-item__error" v-if="errors.description">
						{{ errors.description.join(", ") }}
					</div>
				</el-form-item>

				<el-form-item label="Type" :class="{ 'is-error': errors.type }">
					<el-select
						style="width: 100%"
						v-model="formModel.type"
						placeholder="Type"
						default-first-option
						clearable
						@change="
							documentList = [];
							model.document_id = null;
						"
					>
						<el-option :value="1" label="Document Review"></el-option>
						<el-option :value="2" label="Atestation"></el-option>
						<el-option :value="3" label="Examination"></el-option>
					</el-select>

					<div class="el-form-item__error" v-if="errors.type">
						{{ errors.type.join(", ") }}
					</div>
				</el-form-item>

				<el-form-item
					label="Document"
					:class="{ 'is-error': errors.document_id }"
				>
					<el-select
						style="width: 100%"
						v-model="formModel.document_id"
						placeholder="Select Document"
						filterable
						default-first-option
						clearable
						remote
						:disabled="formModel.type == null"
						:remote-method="(q) => getList(documentUrl, 'documentList', q)"
					>
						<el-option
							v-for="doc in documentList"
							:key="doc.id"
							:value="doc.id"
							:label="doc.title"
						>
							<span
								style="
									float: left;
									color: #8492a6;
									font-size: 13px;
									margin-right: 20px;
								"
								>{{ doc.versions.type_name }} | No.
								{{ doc.versions.number }} Ver. {{ doc.versions.version }}</span
							>
							<span style="float: right; font-size: 14px"
								>{{ doc.title }}
							</span>
						</el-option>
					</el-select>

					<div class="el-form-item__error" v-if="errors.document_id">
						{{ errors.document_id.join(", ") }}
					</div>
				</el-form-item>

				<el-form-item
					label="Assignees"
					:class="{ 'is-error': errors.assignees }"
				>
					<el-select
						style="width: 100%"
						v-model="formModel.assignees"
						placeholder="Assignees"
						filterable
						default-first-option
						clearable
						multiple
					>
						<el-option
							v-for="user in userList"
							:key="user.id"
							:value="user.id"
							:label="`${user.name} | ${user.position} (${
								user.department ? user.department.name : 'N/A'
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
									user.department ? user.department.name : "N/A"
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
						v-model="formModel.due_date"
						type="date"
						format="dd-MMM-yyyy"
						value-format="yyyy-MM-dd"
						placeholder="Due Date"
					></el-date-picker>

					<div class="el-form-item__error" v-if="errors.due_date">
						{{ errors.due_date.join(", ") }}
					</div>
				</el-form-item>

				<el-form-item label="Priority" :class="{ 'is-error': errors.priority }">
					<el-select
						style="width: 100%"
						v-model="formModel.priority"
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
					action=""
					multiple
					:file-list="fileList"
					:on-preview="handlePreview"
					:on-remove="handleRemove"
					:on-success="handleUploadFileSuccess"
					:on-error="handleUploadFileError"
					:http-request="upload"
				>
					<i class="el-icon-upload"></i>
					<div class="el-upload__text">
						Drop file here or <em>click to upload</em>
					</div>
				</el-upload>
			</div>
		</div>

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
				{{ model.id ? "UPDATE" : "SAVE" }}
			</el-button>
		</div>
	</el-dialog>
</template>

<script>
import form from "~/mixins/form";
import dropdown from "~/mixins/dropdown";
import { mapState } from "vuex";

export default {
	props: ["show", "model", "url"],
	mixins: [form, dropdown],
	computed: {
		formModel() {
			return this.model;
		},
		fileList() {
			return this.model.attachments || [];
		},
		documentUrl() {
			if (this.model.type == 3) {
				return "/api/document?has_quizzes=true";
			}
			return "/api/document";
		},
		...mapState(["userList"])
	},
	mounted() {
		this.getList(this.documentUrl, "documentList");
	}
};
</script>
