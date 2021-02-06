<template>
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
							<th scope="col">Title</th>
							<th scope="col">Departments</th>
							<th scope="col">Effective Date</th>
							<th scope="col">Expired Date</th>
							<th scope="col">Owner</th>
							<th class="text-nowrap" scope="col">Last Update</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="doc in tableData" :key="doc.id">
							<td>
								<i class="uil-star"></i>
							</td>
							<td class="text-nowrap">
								Policy No. {{ doc.number }} Ver. {{ doc.version }}
								<br />
								<nuxt-link to="/slug" style="font-size: 17px">
									{{ doc.title }}
								</nuxt-link>
								<br />
								{{ doc.category.join(", ") }}
							</td>
							<td>{{ doc.departments }}</td>
							<td>{{ doc.effective_date }}</td>
							<td>{{ doc.expired_date }}</td>
							<td class="text-nowrap">{{ doc.owner.name }}</td>
							<td class="text-nowrap">{{ doc.last_update }}</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</template>

<script>
import table from '~/mixins/table'

export default {
  mixins: [table],
  props: ['header'],
  head() {
    return {
      title: `${this.title}`,
    };
  },
  data() {
    return {
      url: '/api/document',
      title: "doc",
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

td {
	vertical-align: middle;
}
</style>
