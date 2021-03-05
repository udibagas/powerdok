<template>
	<div class="card">
		<div class="card-header bg-white d-flex">
			<div class="flex-grow-1" style="line-height: 30px">
				<h4 class="text-primary m-0 p-0">
					<i class="uil-file-check-alt"></i> Manage Task
				</h4>
			</div>

			<el-button
				class="btn-primary mr-2"
				size="small"
				icon="el-icon-plus"
				@click="addData"
				>NEW TASK
			</el-button>

			<el-input
				placeholder="Search"
				v-model="keyword"
				prefix-icon="el-icon-search"
				size="small"
				style="width: 200px"
				clearable
				@change="
					() => {
						pagination.current_page = 1;
						fetchData();
					}
				"
			></el-input>
			<el-button
				icon="el-icon-refresh"
				size="small"
				class="ml-2"
				@click="refresh"
			></el-button>
		</div>

		<el-table stripe :data="tableData" v-loading="loading">
			<el-table-column label="#" type="index" :index="pagination.form">
			</el-table-column>

			<el-table-column label="Title">
				<template slot-scope="scope">
					<nuxt-link :to="`/task/${scope.row.id}`">{{
						scope.row.title
					}}</nuxt-link>
				</template>
			</el-table-column>

      <el-table-column prop="assignee.name" label="Assignee"></el-table-column>

			<el-table-column
				prop="type_name"
				label="Type"
				width="150"
			></el-table-column>

			<el-table-column :label="$t('Priority')" width="150">
				<template slot-scope="scope">
					<span :class="`text-${priorityColors[scope.row.priority]}`">{{
						scope.row.priority_label
					}}</span>
				</template>
			</el-table-column>

			<el-table-column prop="due_date" label="Due Date" width="150">
				<template slot-scope="scope">
					{{ $moment(scope.row.due_date).fromNow() }}
				</template>
			</el-table-column>

			<el-table-column label="Status" width="150">
				<template slot-scope="scope">
					<span :class="`text-${statusColors[scope.row.status]}`">{{
						scope.row.status_label
					}}</span>
				</template>
			</el-table-column>
		</el-table>

		<div class="d-flex p-3">
			<el-pagination
				class="flex-grow-1"
				background
				@current-change="
					(p) => {
						pagination.current_page = p;
						fetchData();
					}
				"
				@size-change="
					(s) => {
						pagination.per_page = s;
						fetchData();
					}
				"
				layout="prev, pager, next"
				:page-size="Number(pagination.per_page)"
				:page-sizes="pageSizes"
				:total="pagination.total"
			></el-pagination>

			<div style="line-height: 30px">
				{{ pagination.from }} - {{ pagination.to }} of
				{{ pagination.total }}
			</div>
		</div>

		<TaskForm
			:show="showForm"
			:model="selectedData"
			:url="url"
			@close="showForm = false"
			@refresh="refresh"
		/>
	</div>
</template>

<script>
import table from "@/mixins/table";

export default {
	mixins: [table],
	head() {
		return {
			title: `${this.title}`
		};
	},
	data() {
		return {
			url: "/api/task",
			priorityColors: {
				Low: "secondary",
				Medium: "warning",
				High: "danger",
				Urgent: "danger"
			},
			statusColors: {
				Draft: "secondary",
				Submitted: "warning",
				"On Progress": "primary",
				Finished: "success",
				Closed: "secondary",
				Void: "secondary",
				Postponed: "secondary"
			},
			title: "Powerdok | Manage Task"
		};
	},
	methods: {
		addData() {
			this.selectedData = { attachments: [] };
			this.showForm = true;
		}
	}
};
</script>

<style lang="scss" scoped>
.table-responsive {
	height: calc(100vh - 170px);
}

thead th {
	position: sticky;
	top: 0;
	background: #5b73e8;
	color: white;
}

td {
	vertical-align: middle;
}
</style>
