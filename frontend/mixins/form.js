export default {
  data() {
    return {
      loading: false,
      errors: {},
    }
  },

  methods: {

    submit(id) {
      this.$axios({
        method: id > 0 ? 'put' : 'post',
        url: id > 0 ? `${this.url}/${id}` : this.url,
        data: this.model
      }).then(r => {
        this.$message({
          message: r.data.message,
          type: 'success'
        })
        this.closeForm()
        this.$emit('refresh')
      }).catch(e => {
        this.$message({
          message: e.response.data.message,
          type: 'error'
        })

        if (e.response.status == 422) {
          this.errors = e.response.data.errors
        }
      }).finally(() => this.loading = false)
    },

    closeForm() {
      this.errors = {}
      this.$emit('close')
    }

  }
}
