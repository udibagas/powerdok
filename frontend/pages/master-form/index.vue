<template>
	<el-card>
		<div class="d-flex justify-content-between">
			<h3>Master Form</h3>
			<el-form inline @submit.native.prevent>
				<el-form-item>
					<el-button
						type="primary"
						icon="el-icon-plus"
						@click="$router.push('master-form/form')"
						size="small"
					>
						NEW FORM
					</el-button>
				</el-form-item>

				<el-form-item>
					<el-input
						v-model="keyword"
						placeholder="Search"
						prefix-icon="el-icon-search"
						clearable
						size="small"
						@change="
							pagination.current_page = 1;
							fetchData();
						"
					></el-input>
				</el-form-item>
			</el-form>
		</div>
		<el-table :data="tableData" stripe height="calc(100vh - 265px)">
			<el-table-column type="index" label="#"></el-table-column>
			<el-table-column label="Name" prop="name">
				<template slot-scope="scope">
					<nuxt-link :to="`master-form/form?id=${scope.row.id}`">
						{{ scope.row.name }}
					</nuxt-link>
				</template>
			</el-table-column>
			<el-table-column
				label="Published"
				width="100px"
				align="center"
				header-align="center"
			>
				<template slot-scope="scope">
					<i
						:class="{
							'el-icon-check text-success': scope.row.published,
							'el-icon-close text-danger': !scope.row.published,
						}"
					></i>
				</template>
			</el-table-column>

			<el-table-column
				fixed="right"
				align="center"
				header-align="center"
				width="60"
			>
				<template slot="header">
					<el-button type="text" icon="el-icon-refresh" @click="refresh">
					</el-button>
				</template>

				<template slot-scope="scope">
					<el-dropdown>
						<span class="el-dropdown-link">
							<i class="el-icon-more"></i>
						</span>
						<el-dropdown-menu slot="dropdown">
							<el-dropdown-item
								icon="el-icon-edit"
								@click.native.prevent="
									$router.push(`/master-form/form?id=${scope.row.id}`)
								"
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

		<el-pagination
			class="mt-3"
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
			layout="prev, pager, next, sizes, total"
			:page-size="Number(pagination.per_page)"
			:page-sizes="pageSizes"
			:total="pagination.total"
		></el-pagination>
	</el-card>
</template>

<script>
import table from "~/mixins/table";

export default {
	mixins: [table],

	data() {
		return {
			url: "/api/masterForm"
		};
	}
};
</script>
