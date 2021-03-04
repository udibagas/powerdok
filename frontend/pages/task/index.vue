<template>
	<div class="card">
		<div class="card-header bg-white d-flex mb-3">
			<div class="flex-grow-1" style="font-size: 24px">
				<i class="uil-file-check-alt"></i> {{ $t("My Task") }}
			</div>

			<div>
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
		</div>

		<el-table stripe :data="tableData">
			<el-table-column label="#" type="index" :index="pagination.form">
			</el-table-column>

			<el-table-column label="Title">
				<template slot-scope="scope">
					<nuxt-link :to="`/task/${scope.row.id}`">{{
						scope.row.title
					}}</nuxt-link>
				</template>
			</el-table-column>

			<el-table-column
				prop="type_label"
				label="Type"
				width="150"
			></el-table-column>

			<el-table-column :label="$t('Priority')" width="150">
				<template slot-scope="scope">
					<span :class="priorityColors[scope.row.priority]">{{
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
					<span :class="statusColors[scope.row.status]">{{
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

		<!-- <div class="card-body p-0">
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
						</tr>
					</tbody>
				</table>
			</div>
		</div> -->
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
			filters: { owned: true },
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
			title: "Powerdok | My Task"
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
