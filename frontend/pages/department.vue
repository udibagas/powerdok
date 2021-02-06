<template>
	<div>
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header bg-white text-muted d-flex">
						<div class="flex-grow-1" style="line-height: 30px">
							<strong> Departments </strong>
						</div>
						<el-input
							:placeholder="$t('Search')"
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
							{{ pagination.from }}-{{ pagination.to }} of
							{{ pagination.total }}
						</div>
					</div>
					<div class="card-body p-0">
						<div class="table-responsive mb-0" v-loading="loading">
							<table class="table table-hover table-striped">
								<thead>
									<tr>
										<th scope="col" style="width: 35px">#</th>
										<th scope="col">Name</th>
										<th scope="col">Description</th>
									</tr>
								</thead>
								<tbody>
									<tr v-for="(item, index) in tableData" :key="item.id">
										<td>{{ pagination.from + index }}</td>
										<td>{{ item.name }}</td>
										<td>{{ item.description }}</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import table from '~/mixins/table'

export default {
  mixins: [table],

  head() {
    return {
      title: `${this.title}`,
    };
  },

  data() {
    return {
      url: '/api/department',
      title: "Department",
    }
  },
}
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
</style>
