<template>
	<div>
		<!-- <PageHeader :title="title" :items="items" /> -->
		<el-card :body-style="{ padding: '0' }">
			<div slot="header" class="d-flex">
				<h3 class="flex-grow-1">User</h3>
				<el-form @submit.native.prevent inline>
					<el-form-item class="mb-0">
						<el-button icon="uil-user-plus" class="btn-primary">
							NEW USER
						</el-button>
					</el-form-item>
					<el-form-item class="mb-0">
						<el-input
							prefix-icon="el-icon-search"
							v-model="keyword"
							placeholder="Search"
							clearable
							@change="
								() => {
									pagination.current_page = 1;
									fetchData();
								}
							"
						></el-input>
					</el-form-item>
				</el-form>
			</div>
			<el-table :data="tableData" stripe v-loading="loading">
				<el-table-column
					label="#"
					type="index"
					:index="pagination.from"
				></el-table-column>
				<el-table-column label="Name" prop="name"></el-table-column>
				<el-table-column label="Email" prop="email"></el-table-column>
				<el-table-column
					fixed="right"
					align="center"
					header-align="center"
					width="60"
				>
					<template slot="header">
						<el-button
							type="text"
							icon="uil-refresh"
							@click="refresh"
						></el-button>
					</template>
				</el-table-column>
			</el-table>

			<el-pagination
				class="m-3 text-center"
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
				:page-size="pagination.per_page"
				:page-sizes="pageSizes"
				:total="pagination.total"
			></el-pagination>
		</el-card>
	</div>
</template>

<script>
import table from '../mixins/table'

export default {
  mixins: [table],
  head() {
    return {
      title: this.user
    }
  },

  data() {
    return {
      url: '/api/user',
      title: 'User',
      items: [
        {text: 'Administration'},
        {text: 'User', active: true},
      ]
    }
  }
}
</script>
