<template>
	<el-card :body-style="{ padding: '0' }">
		<div class="d-flex justify-content-between" slot="header">
			<div style="font-size: 1.2rem">
				{{ $t("Manage Task") }}
			</div>

			<div>
				<el-button
					class="mr-2"
					size="small"
					type="primary"
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
		</div>

		<el-table
			stripe
			:data="tableData"
			v-loading="loading"
			height="calc(100vh - 245px)"
			@filter-change="filterChange"
			@sort-change="sortChange"
		>
			<el-table-column label="#" type="index" :index="pagination.form">
			</el-table-column>

			<el-table-column :label="$t('Title')" show-overflow-tooltip>
				<template slot-scope="scope">
					<nuxt-link :to="`/task/${scope.row.id}`">
						{{ scope.row.title }}
					</nuxt-link>
				</template>
			</el-table-column>

			<el-table-column
				prop="assignee.name"
				label="Assignee"
				width="150"
				show-overflow-tooltip
			></el-table-column>

			<el-table-column
				prop="type_name"
				label="Type"
				width="150"
				align="center"
				header-align="center"
				column-key="type"
				:filters="typeList"
			></el-table-column>

			<el-table-column
				prop="due_date"
				:label="$t('Due Date')"
				width="120"
				sortable="custom"
				align="center"
				header-align="center"
			>
				<template slot-scope="scope">
					{{ $moment(scope.row.due_date).fromNow() }}
				</template>
			</el-table-column>

			<el-table-column
				prop="priority"
				:label="$t('Priority')"
				width="120"
				align="center"
				header-align="center"
				column-key="priority"
				:filters="priorityList"
				sortable="custom"
			>
				<template slot-scope="scope">
					<span :class="`text-${priorityColors[scope.row.priority_label]}`">{{
						scope.row.priority_label
					}}</span>
				</template>
			</el-table-column>

			<el-table-column
				label="Status"
				width="150"
				header-align="center"
				align="center"
				column-key="status"
				:filters="statusList"
			>
				<template slot-scope="scope">
					<span :class="`text-${statusColors[scope.row.status_label]}`">{{
						scope.row.status_label
					}}</span>
				</template>
			</el-table-column>

			<el-table-column
				fixed="right"
				width="60"
				header-align="center"
				align="center"
			>
				<template slot-scope="scope">
					<el-dropdown v-if="!scope.row.is_closed">
						<span class="el-dropdown-link">
							<i class="el-icon-more"></i>
						</span>
						<el-dropdown-menu slot="dropdown">
							<el-dropdown-item
								icon="el-icon-edit"
								@click.native.prevent="editData(scope.row)"
								>Edit</el-dropdown-item
							>
							<el-dropdown-item
								icon="el-icon-delete"
								@click.native.prevent="deleteData(scope.row.id)"
								>Delete</el-dropdown-item
							>
						</el-dropdown-menu>
					</el-dropdown>
				</template>
			</el-table-column>
		</el-table>

		<div class="text-right p-3">
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
				layout="sizes, prev, pager, next, total"
				:page-size="Number(pagination.per_page)"
				:page-sizes="pageSizes"
				:total="pagination.total"
			></el-pagination>
		</div>

		<TaskForm
			:show="showForm"
			:model="selectedData"
			:url="url"
			@close="showForm = false"
			@refresh="refresh"
		/>
	</el-card>
</template>

<script>
import table from "@/mixins/table";
import { mapState } from "vuex";

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
			title: "Powerdok | Manage Task"
		};
	},

	computed: {
		...mapState([
			"priorityColors",
			"statusColors",
			"statusList",
			"priorityList",
			"typeList"
		])
	},

	methods: {
		addData() {
			this.selectedData = { attachments: [] };
			this.showForm = true;
		}
	}
};
</script>
