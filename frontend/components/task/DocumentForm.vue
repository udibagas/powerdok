<template>
  <el-card v-loading="loading" class="mt-3">
    <div slot="header" class="d-flex justify-content-between">
      <div>
        {{ $t("DOCUMENT") }}
      </div>
      <div>
        <el-button
          icon="el-icon-document"
          size="small"
          type="primary"
          @click="save"
        >
          {{ $t("SAVE DOCUMENT") }}
        </el-button>

        <el-button
          icon="el-icon-check"
          size="small"
          type="success"
          @click="showForm = true"
        >
          {{ $t("PUBLISH DOCUMENT") }}
        </el-button>
      </div>
    </div>
    <el-form label-position="left" label-width="150px">
      <el-form-item label="Document Title">
        <el-input v-model="form.title" placeholder="Document Title"></el-input>

        <div class="el-form-item__error" v-if="errors.title">
          {{ errors.title.join(", ") }}
        </div>
      </el-form-item>
      <el-form-item label="Document Type">
        <el-select
          v-model="form.type"
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
    </el-form>
    <ckeditor v-model="form.body" :editor="editor"></ckeditor>

    <PublishDocumentForm
      v-if="form.id"
      :show="showForm"
      :task="form"
      @close="showForm = false"
      @refresh="getData"
    />
  </el-card>
</template>

<script>
import CKEditor from "@ckeditor/ckeditor5-vue";
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";

export default {
  props: ["task"],

  mounted() {
    this.getData();
  },

  data() {
    return {
      loading: false,
      form: { body: "" },
      errors: {},
      editor: ClassicEditor,
      showForm: false,
    };
  },
  components: {
    ckeditor: CKEditor.component,
  },
  methods: {
    save() {
      this.loading = true;
      this.$axios
        .$post(`/api/task/updateDocument/${this.task.id}`, this.form)
        .then((response) => {
          this.$message({
            message: response.message,
            type: "success",
          });

          this.errors = {};
          this.getData();
          this.$emit("refresh");
        })
        .catch((e) => {
          if (e.response.status == 422) {
            this.errors = e.response.data.errors;
          }

          this.$message({
            message: e.response.data.message,
            type: "error",
          });
        })
        .finally(() => (this.loading = false));
    },

    getData() {
      this.loading = true;
      this.$axios
        .$get(`/api/task/document/${this.task.id}`)
        .then((response) => {
          this.form = response;
          this.form.body = response.latest_version.body;
        })
        .catch((e) => {
          this.$message({
            message: e.response.data.message,
            type: "error",
          });
        })
        .finally(() => (this.loading = false));
    },
  },
};
</script>
