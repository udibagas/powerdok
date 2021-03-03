export default {
  data() {
    return {
      keyword: '',
      filters: {},
      tableData: [],
      selectedData: {},
      showForm: false,
      sort_field: null,
      sort_direction: null,
      loading: false,
      pagination: {
        current_page: 1,
        from: 0,
        to: 0,
        total: 0,
        per_page: 15
      },
      pageSizes: [15, 20, 50, 100],
      yesNoFilter: [
        {value: 'yes', 'text': 'Yes'},
        {value: 'no', 'text': 'No'},
      ]
    }
  },

  methods: {

    sortChange(c) {
      if (c.prop != this.sort || c.order != this.order) {
        this.sort_field = c.prop;
        this.sort_direction = c.order == 'descending' ? 'desc' : 'asc';
        this.pagination.current_page = 1;
				this.fetchData();
			}
    },

    filterChange(filter) {
      this.filters = {...this.filters, ...filter}
      this.pagination.current_page = 1
      this.fetchData()
    },

    currentChange(page) {
      this.pagination.current_page = page
			this.fetchData()
    },

    refresh() {
      this.pagination.current_page = 1;
      this.keyword = null
      this.sort_field = null
      this.sort_direction = null
      this.fetchData()
    },

    sizeChange(size) {
      this.pagination.per_page = size
			this.pagination.current_page = 1
			this.fetchData()
    },

    fetchData() {
      const params = {
        keyword: this.keyword,
        page: this.pagination.current_page,
        sort_field: this.sort_field,
        sort_direction: this.sort_direction,
        ...this.filters,
        ...this.pagination
      }

      this.loading = true

      this.$axios.$get(this.url, { params }).then(r => {
        this.tableData = r.data
        var meta = {}

        if (r.meta) {
          meta = r.meta
        } else {
          meta = r
        }

        const { current_page, from, to, total, per_page } = meta
        this.pagination = { current_page, from, to, total, per_page }
      }).catch(e => {
        this.$message({
          message: e.response.data.message,
          type: 'error',
        })
      }).finally(() => this.loading = false)
    },

    deleteData(id) {
      this.$confirm('Are you sure want to delete this data?', 'Confirm', { type: 'warning' }).then(() => {
        this.$axios.delete(`${this.url}/${id}`).then(r => {
          this.$message({
            message: r.data.message,
            type: 'success'
          })
          this.fetchData()
        }).catch(e => {
          this.$message({
            message: e.response.data.message,
            type: 'error',
          })
        })
      }).catch(e => console.log(e))
    },

    editData(data) {
      this.selectedData = JSON.parse(JSON.stringify(data))
      this.showForm = true
    },

    addData() {
      this.selectedData = {}
      this.showForm = true
    },

    importData(dataToImport) {
			this.loading = true
			this.$axios
				.post(`${this.url}/import`, { rows: dataToImport })
				.then((r) => {
					this.$message({
						message: r.data.message,
						type: 'success',
					})
					this.fetchData()
				})
				.catch((e) => {
					this.$message({
						message: e.response.data.message,
						type: 'error',
						duration: 10000,
						showClose: true,
					})
				})
				.finally(() => {
					this.loading = false
					document.getElementById('input-file').value = ''
				})
    },
  },

  mounted() {
		this.fetchData()
	},
}
