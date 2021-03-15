export default {
  data() {
    return {
      documentList: [],
    }
  },

  computed: {
    departmentFilter() {
      return this.departmentList.map(u => {
        return {text: u.name, value: u.id}
      })
    }
  },

  methods: {

    getList(url, listContainer, keyword = '') {
      this.$axios.$get(url, { params: { keyword } }).then(r => {
        this[listContainer] = r.data || r
      }).catch(e => {
        this.$message({
          message: e.response.data.message,
          type: 'error'
        })
      })
    }

  }
}
