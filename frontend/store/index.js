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
  async fetchUsers({ commit }) {
    const params = {
      fields: ['id', 'name', 'email', 'position'],
      with: ['department']
    };

    const data = await this.$axios.$get('/api/user', { params });
    commit('setUserList', data);
  },
  async fetchDepartments({ commit }) {
    const params = { fields: ['id', 'name'] };
    const data = await this.$axios.$get('/api/department', { params });
    commit('setDepartmentList', data);
  }
}
