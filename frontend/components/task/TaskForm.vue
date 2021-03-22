<template>
	<el-dialog
		title="TASK"
		width="750px"
		:visible.sync="show"
		:before-close="closeForm"
		:close-on-click-modal="false"
	>
		<el-form label-position="left" label-width="150px">
			<el-form-item label="Title" :class="{ 'is-error': errors.title }">
				<el-input v-model="model.title" placeholder="Title"></el-input>

				<div class="el-form-item__error" v-if="errors.title">
					{{ errors.title.join(", ") }}
				</div>
			</el-form-item>

			<el-form-item :label="$t('Description')">
				<wysiwyg class="mb-3" v-model="model.description"></wysiwyg>
				<div class="el-form-item__error" v-if="errors.description">
					{{ errors.description.join(", ") }}
				</div>
			</el-form-item>

			<el-form-item label="Type" :class="{ 'is-error': errors.type }">
				<el-select
					style="width: 100%"
					v-model="model.type"
					placeholder="Type"
					:disabled="!!model.id"
					@change="
						documentList = [];
						model.document_id = null;
					"
				>
					<el-option
						v-for="t in typeList"
						:key="t.value"
						:value="t.value"
						:label="t.text"
					></el-option>
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
					v-model="model.document_id"
					placeholder="Select Document"
					filterable
					default-first-option
					clearable
					remote
					:disabled="model.type == null"
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
							>{{ doc.type_name }} | No. {{ doc.latest_version.number }} Ver.
							{{ doc.latest_version.version }}</span
						>
						<span style="float: right; font-size: 14px">{{ doc.title }} </span>
					</el-option>
				</el-select>

				<div class="el-form-item__error" v-if="errors.document_id">
					{{ errors.document_id.join(", ") }}
				</div>
			</el-form-item>

			<el-form-item
				:label="$t('Assignees')"
				:class="{ 'is-error': errors.assignees }"
			>
				<el-select
					v-if="!model.id"
					style="width: 100%"
					v-model="model.assignees"
					placeholder="Assignees"
					filterable
					default-first-option
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

				<el-input v-else v-model="model.assignee.name" disabled></el-input>

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

			<el-form-item label="Priority" :class="{ 'is-error': errors.priority }">
				<el-select
					style="width: 100%"
					v-model="model.priority"
					placeholder="Priority"
					filterable
					clearable
					default-first-option
				>
					<el-option
						v-for="p in priorityList"
						:value="p.value"
						:label="p.text"
						:key="p.value"
					></el-option>
				</el-select>

				<div class="el-form-item__error" v-if="errors.priority">
					{{ errors.priority.join(", ") }}
				</div>
			</el-form-item>
			<el-form-item :label="$t('Attachments')">
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
			</el-form-item>
		</el-form>

		<div slot="footer">
			<el-button size="small" icon="el-icon-circle-close" @click="closeForm">
				{{ $t("CANCEL") }}
			</el-button>

			<el-button
				size="small"
				type="primary"
				icon="el-icon-success"
				@click="submit(model.id)"
				:loading="loading"
			>
				{{ model.id ? "UPDATE" : "SUBMIT" }}
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
		fileList() {
			return this.model.attachments || [];
		},
		documentUrl() {
			if (this.model.type == 3) {
				return "/api/document?has_quizzes=true";
			}
			return "/api/document";
		},
		...mapState(["userList", "priorityList", "typeList"])
	},
	mounted() {
		this.getList(this.documentUrl, "documentList");
	}
};
</script>
