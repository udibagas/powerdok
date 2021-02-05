<template>
  <div>
    <PageHeader :title="title" :items="items" />
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-sm-12 col-md-6">
                  <div id="tickets-table_length" class="dataTables_length">
                      <label class="d-inline-flex align-items-center">
                          Show&nbsp;
                          <b-form-select v-model="pagination.per_page" size="sm" :options="pageSizes"></b-form-select>&nbsp;entries
                      </label>
                  </div>
              </div>
              <div class="col-sm-12 col-md-6">
                  <div id="tickets-table_filter" class="dataTables_filter text-md-right">
                      <label class="d-inline-flex align-items-center">
                          Search:
                          <b-form-input v-model="keyword" type="search" placeholder="Search..." class="form-control form-control-sm ml-2"></b-form-input>
                      </label>
                  </div>
              </div>
            </div>
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">Title</th>
                    <th scope="col">Departments</th>
                    <th scope="col">Effective Date</th>
                    <th scope="col">Expired Date</th>
                    <th scope="col">Owner</th>
                    <th scope="col"></th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="documents in tableData" :key="documents.id">
                    <td>
                      <p>No. {{ documents.number }} - ver. {{ documents.version }}</p>
                      <h5>{{ documents.title }}</h5>
                      <p>Category {{ documents.category }}</p>
                    </td>
                    <td>{{ documents.departments }}</td>
                    <td>{{ documents.effective_date }}</td>
                    <td>{{ documents.expired_date }}</td>
                    <td>{{ documents.owner_id }}</td>
                    <td>
                      <button class="btn btn-sm" v-on:click="togglefav" >
                        <i v-bind:class="[is_fav ?  'uil-heart' : 'uil-heart-alt', 'fa']" aria-hidden="true"></i>
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <br/>
            <div class="row">
              <div class="col">
                  <div class="dataTables_paginate paging_simple_numbers float-right">
                      <ul class="pagination pagination-rounded mb-0">
                          <b-pagination v-model="pagination.current_page" :total-rows="pagination.total" :per-page="pagination.per_page"></b-pagination>
                      </ul>
                  </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import table from '~/mixins/table'

export default {
  mixins: [table],
  props: ['is_fav'],
  head() {
    return {
        title: `${this.title}`,
    };
  },
  data() {
    return {
      url: '/api/documents',
      title: "Documents",
      items: [{
          text: "Menu",
        },
        {
          text: "Documents",
          active: true,
        },
      ],
      keyword:''
    }
  },
  methods:{
    togglefav:function(){
      this.$emit('togglefav',!this.is_fav);
    }
  }
}
</script>

<style>

</style>
