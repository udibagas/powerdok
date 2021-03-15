<template>
  <el-dialog
    title="REQUEST APPROVAL"
		:visible.sync="show"
		:before-close="() => {$emit('close')}"
		:close-on-click-modal="false"
    width="700px"
  >

    <el-table :data="approvals">
      <el-table-column label="Level" width="120px">
        <template slot-scope="scope">
          <el-select
            style="width:100%"
            placeholder="Level"
            v-model="scope.row.level"
            default-first-option
            clearable
            :disabled="scope.row.status != null"
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
            :disabled="scope.row.status != null"
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
        <template slot-scope="scope">
          <el-button
            v-if="scope.row.status == null"
            icon="el-icon-delete"
            @click="deleteApproval(scope.$index, scope.row.id)"
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
        type="primary"
			>{{ $t('SUBMIT') }}
			</el-button>
		</div>
  </el-dialog>
</template>

<script>
import { mapState } from 'vuex';
export default {
	props: ['show', 'task', 'approvals', 'action'],
  data() {
    return {
      loading: false,
      errors: {}
    }
  },
  computed: {
    ...mapState(['userList'])
  },

  methods: {
    addApproval() {
      this.approvals.push({
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
            this.approvals.splice(index, 1);
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
          this.approvals.splice(index, 1);
        }
      });
    },
    submit() {
      this.$axios.$post(`/api/task/approval/${this.task.id}`, { approvals: this.approvals }).then(response => {
        this.$message({
          message: response.message,
          type: 'success',
          showClose: true
        });

        this.errors = {};
        this.$emit('close');
        this.$emit('refresh');
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
  }
}
</script>
