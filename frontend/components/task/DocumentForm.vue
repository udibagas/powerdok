<template>
  <el-card v-loading="loading" :header="$t('DOCUMENT')" class="mt-3">
    <el-form label-position="left" label-width="150px">
      <el-form-item label="Document Title">
        <el-input
          v-model="form.title"
          placeholder="Document Title"
        ></el-input>

        <div class="el-form-item__error" v-if="errors.title">
          {{ errors.title.join(", ") }}
        </div>
      </el-form-item>
      <el-form-item label="Document Type">
        <el-select
          v-model="form.type_name"
          style="width: 100%"
          placeholder="Select Type"
          default-first-option
          clearable
        >
          <el-option :value="1" label="SOP"></el-option>
          <el-option :value="2" label="Policy"></el-option>
        </el-select>

        <div class="el-form-item__error" v-if="errors.type">
          {{ errors.type.join(", ") }}
        </div>
      </el-form-item>
      <el-form-item label="Department">
        <el-select
          style="width: 100%"
          v-model="form.departments"
          placeholder="Department"
          filterable
          default-first-option
          clearable
          multiple
        >
          <el-option
            v-for="department in departmentList"
            :key="department.id"
            :value="department.id"
            :label="department.name"
          ></el-option>
        </el-select>

        <div class="el-form-item__error" v-if="errors.departments">
          {{ errors.departments.join(", ") }}
        </div>
      </el-form-item>
    </el-form>
    <ckeditor
      v-model="form.body"
      :editor="editor"
    ></ckeditor>
    <div class="text-right mt-3">
      <el-button
        size="small"
        type="primary"
        @click="save"
      ><i class="el-icon-document mr-1"></i>{{ $t("SAVE DOCUMENT") }}
      </el-button>
    </div>
  </el-card>
</template>

<script>
import CKEditor from "@ckeditor/ckeditor5-vue";
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
import { mapState } from 'vuex';

export default {
	props: ["task"],

  mounted() {
    this.getData();
  },

  data() {
    return {
      loading: false,
      form: { body: '' },
      errors: {},
			editor: ClassicEditor,
    }
  },
  computed: {
    ...mapState(['departmentList'])
  },
  components: {
		ckeditor: CKEditor.component
	},
  methods: {
    save() {
      this.loading = true;
      this.$axios.$post(`/api/task/updateDocument/${this.task.id}`, this.form).then(response => {
        this.$message({
          message: response.message,
          type: 'success',
        });

        this.form = {};
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
        });
      }).finally(() => this.loading = false)
    },

    getData() {
      this.loading = true;
      this.$axios.$get(`/api/task/document/${this.task.id}`).then(response => {
        this.form = response;
        this.form.body = response.latest_version.body;
      }).catch(e => {
         this.$message({
          message: e.response.data.message,
          type: 'error',
        });
      }).finally(() => this.loading = false)
    }
  },
}
</script>

<style>

</style>
