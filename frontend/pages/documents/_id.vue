<template>
	<div class="row">
		<div
			class="col-8 bg-secondary rounded shadow"
			style="height: calc(100vh - 100px)"
		></div>
		<div class="col-4">
			<div class="card">
				<el-tabs class="card-body">
					<el-tab-pane label="Document Information">
						<table class="table table-striped table-hover">
							<tbody>
								<tr>
									<td class="font-weight-bold">Title</td>
									<td>{{ doc.title }}</td>
								</tr>
								<tr>
									<td class="font-weight-bold">Type</td>
									<td>{{ doc.type_name }}</td>
								</tr>
								<tr>
									<td class="font-weight-bold">Number</td>
									<td>{{ doc.number }}</td>
								</tr>
								<tr>
									<td class="font-weight-bold">Version</td>
									<td>{{ doc.version }}</td>
								</tr>
								<tr>
									<td class="font-weight-bold">Owner</td>
									<td>{{ doc.owner.name }}</td>
								</tr>
								<tr>
									<td class="font-weight-bold">Category</td>
									<td>{{ doc.categories.join(",") }}</td>
								</tr>
								<tr>
									<td class="font-weight-bold">Deapartment</td>
									<td>{{ doc.departments }}</td>
								</tr>
							</tbody>
						</table>
					</el-tab-pane>
					<el-tab-pane label="Discussion"></el-tab-pane>
					<el-tab-pane label="Versions">
						<table class="table table-striped table-hover">
							<thead>
								<tr>
									<th class="text-center">Version</th>
									<th class="text-center">Effective Date</th>
									<th class="text-center">Expired Date</th>
									<th class="text-center">File</th>
								</tr>
							</thead>
							<tbody>
								<tr v-for="i in 6" :key="i">
									<td class="font-weight-bold text-center">{{ i }}.0</td>
									<td class="text-center">22-Jun-2020</td>
									<td class="text-center">22-Jun-2021</td>
									<td class="text-center">
										<el-button
											size="mini"
											class="btn-outline-primary"
											icon="el-icon-download"
										></el-button>
									</td>
								</tr>
							</tbody>
						</table>
					</el-tab-pane>
				</el-tabs>
			</div>
		</div>
	</div>
</template>

<script>
export default {
  async asyncData({$axios, params}) {
    const doc = await $axios.$get(`/api/document/${params.id}`);
    return { doc };
  }
}
</script>

<style>
.border-end {
	border-right: 1px solid #ddd;
}
</style>
