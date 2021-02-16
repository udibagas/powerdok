export default {
  data() {
    return {
      // REGISTER ALL LIST HERE
      departmentList: [],
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

    getList(url, keyword, listContainer) {
      this.$axios.get(url, { params: { keyword } }).then(r => {
        this[listContainer] = r.data.data || r.data
      }).catch(e => {
        this.$message({
          message: e.response.data.message,
          type: 'error'
        })
      })
    }

  }
}
