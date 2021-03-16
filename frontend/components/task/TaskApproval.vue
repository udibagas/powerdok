<template>
  <el-card class="mt-3" >
    <div slot="header" class="d-flex justify-content-between">
      <div>APPROVALS</div>
      <el-button size="small" type="primary" icon="el-icon-edit" @click="showForm = true">
        {{ $t(submittedApprovals.length > 0 ? 'EDIT APPROVAL' : 'REQUEST APPROVAL') }}
      </el-button>
    </div>

    <div v-if="submittedApprovals.length > 0">
      <div v-for="approval in submittedApprovals" :key="approval.id" class="mb-4">
        <div class="media mb-3">
          <el-avatar class="mr-3"></el-avatar>
          <div class="media-body row">
            <div class="col">
              <strong>{{ approval.user_id == $auth.user.id ? "Me" : approval.user.name }}</strong>
              <div class="text-muted">
                {{ approval.user.position }} |
                {{ approval.user.department ? approval.user.department.name : "N/A" }}
              </div>
            </div>
            <div class="col text-right">
              <span class="text-muted">
                {{ $moment(approval.updated_at).fromNow() }} &bull;
              </span>
              <el-tag
                v-if="approval.status !== null"
                effect="dark"
                :type="approval.status ? 'success' : 'danger'"
              >{{approval.status ? $t('APPROVED') : $t('DECLINED')}}
              </el-tag>
              <el-tag
                v-else
                effect="dark"
                type="info"
              >{{$t("WAITING")}}
              </el-tag>
            </div>
          </div>
        </div>
        <div class="mb-3" v-if="approval.user_id == $auth.user.id && approval.status == null">
          <el-input
            type="textarea"
            rows="3"
            v-model="approval.note"
            placeholder="Note"
          ></el-input>
          <div class="mt-2">
            <el-button size="mini" type="danger" @click="approve(false, approval.note)">
              <i class="el-icon-close mr-1"></i>{{ $t('DECLINE') }}
            </el-button>
            <el-button size="mini" type="success" @click="approve(true, approval.note)">
              <i class="el-icon-check mr-1"></i>{{ $t('APPROVE') }}
            </el-button>
          </div>
        </div>
        <div class="mb-3" v-else>
          {{ approval.note }}
        </div>
      </div>
    </div>

    <div v-else class="text-center">
      <h3>NO APPROVAL FOUND</h3>
    </div>

    <RequestApprovalForm
      :show="showForm"
      :task="task"
      :approvals="approvals"
      @close="showForm = false"
      @refresh="getData"
    />
  </el-card>
</template>

<script>
export default {
  props: ['task'],

  computed: {
    submittedApprovals() {
      return this.approvals.filter(a => {
        return "user" in a;
      });
    }
  },

  mounted() {
    this.getData();
  },

  data() {
    return {
      approvals: [],
      showForm: false,
    }
  },

  methods: {
    approve(status, note) {
      this.$confirm("Are you sure want to save your response ?", "Confirm").then(() => {
        this.$axios.$post(`/api/task/approve/${this.task.id}`, { status, note }).then(response => {
          this.$message({
            message: response.message,
            type: 'success',
            showClose: true
          });

          this.errors = {};
          this.getData();
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
      });
    },
    getData() {
      this.$axios.$get(`/api/task/approvals/${this.task.id}`).then(response => this.approvals = response)
    }
  }
}
</script>
