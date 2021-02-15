<template>
	<div class="card">
		<div class="card-header bg-white d-flex">
			<div class="flex-grow-1" style="line-height: 30px">
				<h4 class="text-primary m-0 p-0">
          <i icon="uil-file-alt"></i>
          Manage SOP / Policy
        </h4>
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
							<th class="text-nowrap" scope="col">Title</th>
							<th class="text-nowrap" scope="col">Departments</th>
							<th class="text-nowrap" scope="col">Effective Date</th>
							<th class="text-nowrap" scope="col">Expired Date</th>
							<th class="text-nowrap" scope="col">Owner</th>
							<th class="text-nowrap" scope="col">Last Update</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="doc in tableData" :key="doc.id">
							<td>
								<i class="uil-star" style="font-size: 20px"></i>
							</td>
							<td class="text-nowrap">
								<strong class="text-muted">
									{{ doc.type_name }} No. {{ doc.number }} Ver.
									{{ doc.version }}
								</strong>
								<br />
								<nuxt-link
									:to="`/documents/${doc.slug}`"
									style="font-size: 17px"
								>
									{{ doc.title }}
								</nuxt-link>
								<br />
								<em>{{ doc.categories.join(", ") }}</em>
							</td>
							<td>
								<nuxt-link
									class="mr-1"
									v-for="(name, id) in doc.departments"
									:key="id"
									:to="`/documents?department_id=${id}`"
									>{{ name }}</nuxt-link
								>
							</td>
							<td class="text-nowrap">
								{{ readableDate(doc.effective_date) }}
							</td>
							<td class="text-nowrap">{{ readableDate(doc.expired_date) }}</td>
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
import moment from 'moment'

export default {
  mixins: [table],
  props: ['header', 'icon'],
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

  methods: {
    readableDate(date) {
      return moment(date).format('DD-MMM-YYYY')
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
	color: white;
}

td {
	vertical-align: middle;
}
</style>
