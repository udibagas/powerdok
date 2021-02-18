<template>
	<div class="card">
		<div class="card-header bg-white text-muted d-flex">
			<div class="flex-grow-1" style="line-height: 30px">
				<strong> {{ $t("Notifications") }} </strong>
			</div>
			<el-button
				class="mr-2 btn-danger"
				size="mini"
				icon="el-icon-delete"
				@click="addData"
				>{{ $t("DELETE NOTIFICATION") }}
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
			<table class="table table-striped table-hover">
				<thead>
					<tr>
						<th class="text-center">
							<el-checkbox v-model="selectAll"></el-checkbox>
						</th>
						<th>Title</th>
						<th>Text</th>
						<th style="min-width: 150px" class="text-center">Time</th>
					</tr>
				</thead>
				<tbody>
					<tr
						v-for="item in tableData"
						:key="item.id"
						:class="{ 'font-weight-bold': item.read_at == null }"
					>
						<td class="text-center">
							<el-checkbox v-model="selected" :value="item.id"></el-checkbox>
						</td>
						<td>{{ item.data.title }}</td>
						<td>{{ item.data.text }}</td>
						<td class="text-center text-muted">
							{{ readableTime(item.created_at) }}
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</template>

<script>
import table from '@/mixins/table';
import moment from 'moment';

export default {
  mixins: [table],
  data() {
    return {
      url: '/api/notification',
      selected: [],
      selectAll: false
    }
  },

  methods: {
    readableTime(time) {
      return moment(time).lang(this.$i18n.locale).fromNow();
    }
  }
}
</script>

<style>
td,
th {
	vertical-align: middle;
}
</style>
