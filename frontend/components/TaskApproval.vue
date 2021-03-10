<template>
  <el-card class="mt-3">
    <div slot="header" class="d-flex justify-content-between">
      <div>APPROVALS</div>
      <el-button size="small" type="primary" icon="el-icon-edit">EDIT APPROVAL</el-button>
    </div>
    <div v-for="approval in task.approvals" :key="approval.id">
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
              :type="approval.status ? 'success' : 'error'"
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
      <div class="mb-3 text-right" v-if="approval.user_id == $auth.user.id && approval.status == null">
        <el-input
          type="textarea"
          rows="3"
          v-model="approval.note"
          placeholder="Note"
        ></el-input>
        <div class="mt-2">
          <el-button size="mini" type="danger" @click="approve(false)">
            <i class="el-icon-close mr-1"></i>{{ $t('DECLINE') }}
          </el-button>
          <el-button size="mini" type="success" @click="approve(true)">
            <i class="el-icon-check mr-1"></i>{{ $t('APPROVE') }}</el-button>
        </div>
      </div>
    </div>
  </el-card>
</template>

<script>
export default {
  props: ['task'],

  methods: {
    approve(status) {
      // TODO : confirm
    }
  }
}
</script>

<style>

</style>
