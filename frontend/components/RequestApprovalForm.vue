<template>
  <el-dialog
    title="REQUEST APPROVAL"
		:visible.sync="show"
		:before-close="() => {$emit('close')}"
		:close-on-click-modal="false"
  >

    <el-table :data="task.approvals">
      <el-table-column label="Level" width="120px">
        <template slot-scope="scope">
          <el-select
            style="width:100%"
            placeholder="Level"
            v-model="scope.row.level"
            default-first-option
            clearable
          >
            <el-option v-for="i in 5" :value="i" :label="i" :key="i"></el-option>
          </el-select>
        </template>
      </el-table-column>

      <el-table-column
        label="Name"
      >
        <template slot-scope="scope">
          <el-select
            style="width: 100%"
            placeholder="Name"
            v-model="scope.row.user_id"
            filterable
            default-first-option
            clearable
            remote
            :remote-method="(q) => getList('/api/user', 'userList', q)"
          >
            <el-option
              v-for="user in userList"
              :key="user.id"
              :value="user.id"
              :label="`${user.name} | ${user.position} (${user.department ? user.department.name : 'N/A'})`"
            >
              <span style="float: left">{{ user.name }}</span>
              <span
                style="
                  float: right;
                  color: #8492a6;
                  font-size: 13px;
                  margin-right: 20px;
                "
              >{{ user.position }} ({{ user.department ? user.department.name : 'N/A' }})
              </span>
            </el-option>
          </el-select>
        </template>
      </el-table-column>

      <el-table-column width="60" align="center" header-align="center">
        <template slot="header">
          <el-button
            icon="el-icon-plus"
            type="text"
            @click="addApproval"
          ></el-button>
        </template>
        <template>
          <el-button
            icon="el-icon-delete"
            @click="deleteApproval"
            type="text"
          ></el-button>
        </template>
      </el-table-column>
    </el-table>

    <div slot="footer">
			<el-button
        size="small"
        icon="el-icon-circle-close"
        @click="$emit('close')"
      >{{ $t('CANCEL') }}
			</el-button>

			<el-button
				size="small"
				class="btn-primary"
				icon="el-icon-success"
				@click="submit"
				:loading="loading"
			>{{ $t('SUBMIT') }}
			</el-button>
		</div>
  </el-dialog>
</template>

<script>
import dropdown from "~/mixins/dropdown";

export default {
	props: ['show', 'task'],
	mixins: [dropdown],
  data() {
    return {
      loading: false,
      errors: {}
    }
  },
  methods: {
    addApproval() {
      this.task.approvals.push({
        level: '',
        user_id: '',
      })
    },
    deleteApproval(index, id) {
      this.$confirm("Are you sure want to delete this approval?", "Confirm", {type: "warning"}).then(() => {
        if(id) {
          this.$axios.$delete(`api/task/approval/${id}`)
          .then(r => {
            this.$message({
              message: r.message,
              type: "success",
              showClose: true
            });
            this.task.approvals.splice(index, 1);
          })
          .catch(e => {
            this.$message({
              message: e.response.data.message,
              type: "error",
              showClose: true
            });
          })
          .finally(() => (this.loading = false));
        } else {
          this.task.approvals.splice(index, 1);
        }
      });
    },
    submit() {
      this.$axios.$post(`/api/task/approval/${this.task.id}`, { approvals: this.task.approvals }).then(response => {
        this.$message({
          message: response.message,
          type: 'success',
          showClose: true
        });

        this.task.approvals = {};
        this.errors = {};
        this.$emit('refresh', response.task.approvals);
      }).catch(e => {
        if (e.response.status == 422) {
          this.errors = e.response.data.errors;
        }

        this.$message({
          message: e.response.data.message,
          type: 'error',
          showClose: true
        });
      })
    },
  },
  mounted() {
		this.getList("/api/user", "userList");
  }
}
</script>
