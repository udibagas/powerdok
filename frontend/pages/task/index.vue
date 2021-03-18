<template>
	<el-card :body-style="{ padding: '0' }">
		<div class="d-flex justify-content-between" slot="header">
			<div style="font-size: 1.2rem">
				{{ $t("My Task") }}
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
					<nuxt-link :to="`/task/${scope.row.id}`">{{
						scope.row.title
					}}</nuxt-link>
				</template>
			</el-table-column>

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
				label="Due Date"
				width="120"
				sortable="custom"
				align="center"
				header-align="center"
			>
				<template slot-scope="scope">
					<span
						:class="{
							'text-danger': scope.row.overdue && !scope.row.is_closed,
						}"
					>
						{{ $moment(scope.row.due_date).fromNow() }}
					</span>
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

	computed: {
		...mapState([
			"priorityColors",
			"statusColors",
			"statusList",
			"priorityList",
			"typeList"
		])
	},

	data() {
		return {
			url: "/api/task",
			filters: { assigned: true },
			title: "Powerdok | My Task"
		};
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
