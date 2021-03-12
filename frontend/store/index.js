export const state = () => ({
  userList: [],
  departmentList: []
});

export const mutations = {
  setUserList(state, data) {
    state.userList = data;
  },
  setDepartmentList(state, data) {
    state.departmentList = data;
  }
}

export const actions = {
  async fetchUsers({commit}) {
    const data = await this.$axios.$get('/api/user');
    commit('setUserList', data);
  },
  async fetchDepartments({commit}) {
    const data = await this.$axios.$get('/api/department');
    commit('setDepartmentList', data);
  }
}
