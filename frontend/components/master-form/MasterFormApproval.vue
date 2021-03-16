<template>
	<el-table :data="model.approvals">
		<el-table-column label="Level" width="120">
			<template slot-scope="scope">
				<el-select v-model="scope.row.level" size="small" style="width: 100%">
					<el-option v-for="i in 7" :key="i" :value="i" :label="i"></el-option>
				</el-select>
			</template>
		</el-table-column>
		<el-table-column label="Approver">
			<template slot-scope="scope">
				<el-select
					size="small"
					v-model="scope.row.user_id"
					placeholder="Approver"
					style="width: 100%"
					filterable
					default-first-option
				>
					<el-option
						v-for="user in userList"
						:key="user.id"
						:value="user.id"
						:label="user.name"
					>
						<!-- TODO: kasih avatar -->
						<span style="float: left">{{ user.name }}</span>
						<span
							style="
								float: right;
								color: #8492a6;
								font-size: 13px;
								margin-right: 20px;
							"
						>
							{{ user.position }} ({{
								user.department ? user.department.name : "N/A"
							}})
						</span>
					</el-option>
				</el-select>
			</template>
		</el-table-column>

		<el-table-column width="60" align="center" header-align="center">
			<template #header>
				<el-button type="text" icon="el-icon-plus" @click="addItem"></el-button>
			</template>

			<template slot-scope="scope">
				<el-button
					type="text"
					icon="el-icon-delete"
					@click="deleteItem(scope.$index)"
				></el-button>
			</template>
		</el-table-column>
	</el-table>
</template>

<script>
import { mapState } from "vuex";
export default {
	props: ["model"],

	computed: {
		...mapState(["userList"])
	},

	methods: {
		addItem() {
			if (this.model.approvals == null) {
				this.model.approvals = [];
			}

			this.model.approvals.push({ level: "", user_id: "" });
		},

		deleteItem(index) {
			this.model.approvals.splice(index, 1);
		}
	}
};
</script>
