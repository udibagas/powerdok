<template>
	<div>
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header bg-white text-muted d-flex">
						<div class="flex-grow-1" style="line-height: 30px">
							<strong><i class="uil-sitemap"></i> Departments </strong>
						</div>
            <el-button
              class="mr-2 btn-primary"
							size="mini"
							icon="el-icon-plus"
							@click="addData"
						>Create New
            </el-button>
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
										<th scope="col" class="text-center">Action</th>
									</tr>
								</thead>
								<tbody>
									<tr v-for="(item, index) in tableData" :key="item.id">
										<td>{{ pagination.from + index }}</td>
										<td>{{ item.name }}</td>
										<td>{{ item.description }}</td>
                    <td class="text-center">
                      <el-dropdown>
                        <span class="el-dropdown-link">
                          <i class="el-icon-more"></i>
                        </span>
                        <el-dropdown-menu slot="dropdown">
                          <el-dropdown-item
                            icon="el-icon-edit"
                            @click.native.prevent="editData(item)"
                            >Edit</el-dropdown-item
                          >
                          <el-dropdown-item
                            icon="el-icon-delete"
                            @click.native.prevent="deleteData(item.id)"
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
				</div>
			</div>
		</div>
    <DepartmentForm
			:show="showForm"
			:model="selectedData"
			:url="url"
			@close="showForm = false"
			@refresh="refresh"
		/>
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
      title: "Powerdok | Departments",
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
