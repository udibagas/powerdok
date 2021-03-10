<template>
	<div>
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header bg-white text-muted d-flex">
						<div class="flex-grow-1" style="line-height: 30px">
							<strong> {{ header }} </strong>
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
							{{ pagination.from }} - {{ pagination.to }} of
							{{ pagination.total }}
						</div>
					</div>
					<div class="card-body p-0">
						<div class="table-responsive mb-0" v-loading="loading">
							<table class="table table-hover table-striped">
								<thead>
									<tr>
										<th scope="col" style="width: 35px"></th>
										<th scope="col" style="width: 80px">Number</th>
										<th scope="col" style="width: 80px">Version</th>
										<th scope="col" style="width: 100px">Type</th>
										<th scope="col">Title</th>
										<!-- <th scope="col">Category</th> -->
										<!-- <th scope="col">Departments</th> -->
										<!-- <th scope="col">Effective Date</th> -->
										<!-- <th scope="col">Expired Date</th> -->
										<th scope="col">Owner</th>
										<th class="text-nowrap" scope="col">Last Update</th>
									</tr>
								</thead>
								<tbody>
									<tr v-for="doc in tableData" :key="doc.id">
										<td>
											<i class="uil-star"></i>
										</td>
										<td>{{ doc.number }}</td>
										<td>{{ doc.version }}</td>
										<td class="text-nowrap">SOP</td>
										<td class="text-nowrap">
											<nuxt-link to="/slug">
												{{ doc.title }}
											</nuxt-link>
										</td>
										<!-- <td>
											<span
												v-for="(category, i) in doc.category"
												class="badge bg-info text-white m-1 p-2"
												:key="i"
												>{{ category }}</span
											>
										</td> -->
										<!-- <td>{{ doc.departments }}</td> -->
										<!-- <td>{{ doc.effective_date }}</td> -->
										<!-- <td>{{ doc.expired_date }}</td> -->
										<td class="text-nowrap">{{ doc.owner.name }}</td>
										<td class="text-nowrap">{{ doc.last_update }}</td>
									</tr>
								</tbody>
							</table>
						</div>

						<!-- <div class="dataTables_paginate paging_simple_numbers">
							<ul class="pagination pagination-rounded">
								<b-pagination
									v-model="pagination.current_page"
									:total-rows="pagination.total"
									:per-page="pagination.per_page"
								></b-pagination>
							</ul>
						</div> -->
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
  props: ['is_fav', 'header'],
  head() {
    return {
      title: `${this.title}`,
    };
  },
  data() {
    return {
      url: '/api/document',
      title: "doc",
      items: [
        {
          text: "doc",
          active: true,
        },
      ],
      keyword:''
    }
  },
  methods:{
    togglefav:function(){
      this.$emit('togglefav',!this.is_fav);
    }
  }
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
	// background: #6e49eb;
	color: white;
}
</style>
