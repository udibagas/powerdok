<template>
  <el-dialog
    title="PUBLISH DOCUMENT"
		:visible.sync="show"
		:before-close="() => {$emit('close')}"
		:close-on-click-modal="false"
    width="600px"
  >
    <el-form label-position="left" label-width="200px">
      <el-form-item label="Document Title" :class="{ 'is-error': errors.title }">
        <el-input
          v-model="task.document.title"
          placeholder="Document Title"
        ></el-input>

        <div class="el-form-item__error" v-if="errors.title">
          {{ errors.title.join(", ") }}
        </div>
      </el-form-item>
      <el-form-item label="Document Type" :class="{ 'is-error': errors.type_name }">
        <el-select
          v-model="task.document.type"
          style="width: 100%"
          placeholder="Select Type"
          default-first-option
          clearable
        >
          <el-option :value="0" label="SOP"></el-option>
          <el-option :value="1" label="Policy"></el-option>
        </el-select>

        <div class="el-form-item__error" v-if="errors.type">
          {{ errors.type.join(", ") }}
        </div>
      </el-form-item>
      <el-form-item label="Document Number" :class="{ 'is-error': errors.number }">
        <el-input
          v-model="form.number"
          placeholder="Number"
        ></el-input>

        <div class="el-form-item__error" v-if="errors.number">
          {{ errors.number.join(", ") }}
        </div>
      </el-form-item>
      <el-form-item label="Document Version" :class="{ 'is-error': errors.version }">
        <el-input
          v-model="form.version"
          placeholder="Version"
        ></el-input>

        <div class="el-form-item__error" v-if="errors.version">
          {{ errors.version.join(", ") }}
        </div>
      </el-form-item>
      <el-form-item label="Effective Date" :class="{ 'is-error': errors.effective_date }">
        <el-date-picker
          style="width: 100%"
          v-model="form.effective_date"
          type="date"
          format="dd-MMM-yyyy"
          value-format="yyyy-MM-dd"
          placeholder="Effective Date"
        ></el-date-picker>

        <div class="el-form-item__error" v-if="errors.effective_date">
          {{ errors.effective_date.join(", ") }}
        </div>
      </el-form-item>
      <el-form-item label="Expired Date" :class="{ 'is-error': errors.expired_date }">
        <el-date-picker
          style="width: 100%"
          v-model="form.expired_date"
          type="date"
          format="dd-MMM-yyyy"
          value-format="yyyy-MM-dd"
          placeholder="Expired Date"
        ></el-date-picker>

        <div class="el-form-item__error" v-if="errors.expired_date">
          {{ errors.expired_date.join(", ") }}
        </div>
      </el-form-item>
      <el-form-item label="Categories" :class="{ 'is-error': errors.categories }">
        <el-select
          v-model="form.categories"
          style="width: 100%"
          placeholder="Select Categories"
          default-first-option
          filterable
          allow-create
          multiple
        ></el-select>

        <div class="el-form-item__error" v-if="errors.categories">
          {{ errors.categories.join(", ") }}
        </div>
      </el-form-item>
      <el-form-item label="Tags" :class="{ 'is-error': errors.tags }">
        <el-select
          v-model="form.tags"
          style="width: 100%"
          placeholder="Select Tags"
          default-first-option
          filterable
          allow-create
          multiple
        ></el-select>

        <div class="el-form-item__error" v-if="errors.tags">
          {{ errors.tags.join(", ") }}
        </div>
      </el-form-item>
      <el-form-item label="Departments" :class="{ 'is-error': errors.departments }">
        <el-select
          style="width: 100%"
          v-model="form.departments"
          placeholder="Departments"
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
      <el-form-item label="Is Public">
        <el-switch
          active-text="Yes"
          inactive-text="No"
          v-model="form.is_public"
        ></el-switch>

        <div class="el-form-item__error" v-if="errors.is_public">
          {{ errors.is_public.join(", ") }}
        </div>
      </el-form-item>
    </el-form>
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
				@click="publish"
				:loading="loading"
        type="primary"
			>{{ $t('PUBLISH') }}
			</el-button>
		</div>
  </el-dialog>
</template>

<script>
import { mapState } from 'vuex';
export default {
	props: ['show', 'task'],
  data() {
    return {
      loading: false,
      errors: {},
      form: {}
    }
  },

  mounted() {
    this.form = this.task.document.latest_version;
    // this.form.title = this.task.document.title;
    // this.form.type = this.task.document.type;
    this.form.categories = this.task.document.categories;
    this.form.tags = this.task.document.tags;
    this.form.departments = this.task.document.departments;
  },

  computed: {
    ...mapState(['departmentList'])
  },

  methods: {
    publish() {
      this.$confirm("Are you sure want to publish this document?", "Confirm").then(() => {
        this.$axios.$post(`/api/task/publishDocument/${this.task.id}`, this.form, this.task).then(response => {
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
      });
    }
  },
}
</script>
