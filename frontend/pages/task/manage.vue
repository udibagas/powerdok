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
			<el-button icon="uil-filter" size="small" class="ml-2"></el-button>
			<el-button
				icon="uil-refresh"
				size="small"
				class="ml-2"
				@click="refresh"
			></el-button>
			<el-pagination
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
				layout="prev, next"
				:page-size="Number(pagination.per_page)"
				:page-sizes="pageSizes"
				:total="pagination.total"
			></el-pagination>

			<div style="line-height: 30px">
				{{ pagination.from }} - {{ pagination.to }} of
				{{ pagination.total }}
			</div>
		</div>

		<div class="card-body p-0">
			<div class="table-responsive mb-0" v-loading="loading">
				<table class="table table-hover table-striped">
					<thead>
						<tr>
							<th>#</th>
							<th style="width: 200px">Title</th>
							<th>Assignee</th>
							<th>Type</th>
							<th class="text-center">Due Date</th>
							<th class="text-center">Priority</th>
							<th class="text-center">Status</th>
							<th class="text-center">Action</th>
						</tr>
					</thead>
					<tbody>
						<tr
							v-for="(task, index) in tableData"
							:key="task.id"
							:class="{ 'table-danger': task.overdue }"
						>
							<td>{{ pagination.from + index }}</td>
							<td>
								<nuxt-link class="text-nowrap" :to="`/task/${task.id}`">{{
									task.title
								}}</nuxt-link>
							</td>
							<td>{{ task.assignee.name }}</td>
							<td>{{ task.type_name }}</td>
							<td class="text-center">
								{{ $moment(task.due_date).fromNow() }}
							</td>
							<td class="text-center">
								<span
									:class="`badge badge-${priorityColors[task.priority_label]}`"
									>{{ task.priority_label }}</span
								>
							</td>
							<td class="text-center">
								<span
									:class="`badge badge-${statusColors[task.status_label]}`"
									>{{ task.status_label }}</span
								>
							</td>
							<td class="text-center">
								<el-dropdown>
									<span class="el-dropdown-link">
										<i class="el-icon-more"></i>
									</span>
									<el-dropdown-menu slot="dropdown">
										<el-dropdown-item
											icon="el-icon-view"
											@click.native="$router.push(`/task/${task.id}`)"
											>Show</el-dropdown-item
										>
										<el-dropdown-item
											icon="el-icon-edit"
											@click.native.prevent="editData(task)"
											>Edit</el-dropdown-item
										>
										<el-dropdown-item
											icon="el-icon-delete"
											@click.native.prevent="deleteData(task.id)"
											>Delete</el-dropdown-item
										>
									</el-dropdown-menu>
								</el-dropdown>
							</td>
						</tr>
					</tbody>
				</table>
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
