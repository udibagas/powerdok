<template>
	<div>
		<el-form>
			<el-form-item>
				<el-input
					v-model="form.body"
					type="textarea"
					rows="5"
					placeholder="Type your comment here"
				></el-input>
			</el-form-item>

			<!-- <el-form-item label="Due Date" :class="{ 'is-error': errors.due_date }">
				<el-date-picker
					style="width: 100%"
					v-model="form.due_date"
					type="date"
					format="dd-MMM-yyyy"
					value-format="yyyy-MM-dd"
					placeholder="Due Date"
				></el-date-picker>

				<div class="el-form-item__error" v-if="errors.due_date">
					{{ errors.due_date.join(", ") }}
				</div>
			</el-form-item> -->

			<!-- <el-form-item label="Priority">
				<el-select
					style="width: 100%"
					v-model="form.priority"
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
			</el-form-item> -->
		</el-form>

		<div>
			<el-button size="small" type="primary" @click="save">
				<i class="uil-comment-dots mr-1"></i> {{ $t("COMMENT") }}
			</el-button>
			<el-button
				size="small"
				type="info"
				class="btn-success"
				icon="el-icon-paperclip"
			>
				{{ $t("ATTACH") }}
			</el-button>
		</div>
	</div>
</template>

<script>
export default {
	props: ["url"],

	data() {
		return {
			form: {},
			errors: {}
		};
	},

	methods: {
		save() {
			this.$axios
				.$post(this.url, this.form)
				.then(response => {
					this.$message({
						message: response.message,
						type: "success",
						showClose: true
					});

					this.form = {};
					this.errors = {};
					this.$emit("refresh", response.task);
				})
				.catch(e => {
					if (e.response.status == 422) {
						this.errors = e.response.data.errors;
					}

					this.$message({
						message: e.response.data.message,
						type: "error",
						showClose: true
					});
				});
		}
	}
};
</script>
