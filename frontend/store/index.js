export const state = () => ({
  userList: []
});

export const mutations = {
  setUserList(state, data) {
    state.userList = data;
  }
}

export const actions = {
  async fetchUsers({commit}) {
    const data = await this.$axios.$get('/api/user');
    commit('setUserList', data);
  }
}
