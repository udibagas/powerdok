<template>
	<el-card header="MASTER FORM">
		<el-form label-width="200px" label-position="left">
			<el-form-item label="Name" :class="{ 'is-error': errors.name }">
				<el-input v-model="model.name" placeholder="Name"></el-input>

				<div class="el-form-item__error" v-if="errors.name">
					{{ errors.name.join(", ") }}
				</div>
			</el-form-item>

			<el-form-item
				label="Description"
				:class="{ 'is-error': errors.description }"
			>
				<el-input
					v-model="model.description"
					placeholder="Description"
				></el-input>

				<div class="el-form-item__error" v-if="errors.description">
					{{ errors.description.join(", ") }}
				</div>
			</el-form-item>

			<el-form-item label="Publish">
				<el-checkbox v-model="model.published">Yes</el-checkbox>
			</el-form-item>
		</el-form>

		<el-tabs type="card">
			<el-tab-pane label="FORM">
				<el-table :data="model.fields">
					<el-table-column label="Name">
						<template slot-scope="scope">
							<el-input
								size="small"
								v-model="scope.row.name"
								placeholder="Name"
							></el-input>
						</template>
					</el-table-column>

					<el-table-column label="Type">
						<template slot-scope="scope">
							<el-select
								size="small"
								v-model="scope.row.type"
								placeholder="Type"
							>
								<el-option
									v-for="(type, i) in inputTypes"
									:key="i"
									:value="type.value"
									:label="type.label"
								></el-option>
							</el-select>
						</template>
					</el-table-column>

					<el-table-column label="Validation">
						<template slot-scope="scope">
							<el-select
								size="small"
								v-model="scope.row.validation"
								placeholder="Validation"
								clearable
								multiple
								style="width: 100%"
							>
								<el-option
									v-for="(validation, i) in validationList"
									:key="i"
									:value="validation"
									:label="validation"
								></el-option>
							</el-select>
						</template>
					</el-table-column>

					<el-table-column label="Data Source">
						<template slot-scope="scope">
							<el-input
								size="small"
								v-model="scope.row.data_source"
								placeholder="Data Source"
							>
								<el-button slot="append" icon="el-icon-search"></el-button>
							</el-input>
						</template>
					</el-table-column>

					<el-table-column header-align="center" align="center" width="60">
						<template slot="header">
							<el-button
								@click="newField"
								type="text"
								icon="el-icon-plus"
							></el-button>
						</template>

						<template slot-scope="scope">
							<el-button
								type="text"
								icon="el-icon-delete"
								@click="deleteField(scope.$index)"
							></el-button>
						</template>
					</el-table-column>
				</el-table>
			</el-tab-pane>
			<el-tab-pane label="APPROVAL">
				<MasterFormApproval :model="model" />
			</el-tab-pane>
			<el-tab-pane label="NOTIFICATION"></el-tab-pane>
		</el-tabs>

		<div class="text-right mt-4">
			<el-button
				type="primary"
				icon="el-icon-success"
				@click="submit(model.id)"
				:loading="loading"
			>
				{{ model.id ? "UPDATE" : "SAVE" }}
			</el-button>
		</div>
	</el-card>
</template>

<script>
import form from "~/mixins/form";
import dropdown from "~/mixins/dropdown";

export default {
	mixins: [form, dropdown],

	async asyncData({ $axios, query }) {
		let model = {};

		if (query.id) {
			model = await $axios.$get(`/api/masterForm/${query.id}`);
		}

		return { model };
	},

	data() {
		return {
			url: "/api/masterForm",
			inputTypes: [
				{ value: "text", label: "text" },
				{ value: "textarea", label: "textarea" },
				{ value: "select", label: "select" },
				{ value: "date", label: "date" },
				{ value: "file", label: "file" }
			],
			validationList: ["required", "number", "date", "file"]
		};
	},

	methods: {
		newField() {
			if (!this.model.fields) {
				this.model.fields = [];
			}

			this.model.fields.push({
				name: "",
				type: "",
				validation: "",
				data_source: ""
			});

			this.$forceUpdate();
		},

		deleteField(index) {
			this.model.fields.splice(index, 1);
		}
	}
};
</script>
