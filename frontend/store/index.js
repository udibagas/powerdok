export const state = () => ({
  userList: [],
  departmentList: [],
  priorityList: [],
  statusList: [],
  typeList: [],
  priorityColors: {
    Low: "muted",
    Medium: "warning",
    High: "danger",
    Urgent: "danger"
  },
  statusColors: {
    New: "warning",
    "On Progress": "primary",
    Finished: "success",
    Closed: "secondary",
    Void: "secondary",
    Postponed: "secondary"
  },
});

export const mutations = {
  setUserList(state, data) {
    state.userList = data;
  },

  setDepartmentList(state, data) {
    state.departmentList = data;
  },

  setStatusList(state, data) {
    state.statusList = Object.keys(data).map(key => {
      return { value: parseInt(key), text: data[key] }
    });
  },

  setTypeList(state, data) {
    state.typeList = Object.keys(data).map(key => {
      return { value: parseInt(key), text: data[key] }
    });
  },

  setPriorityList(state, data) {
    state.priorityList = Object.keys(data).map(key => {
      return { value: parseInt(key), text: data[key] }
    });
  },
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
  },

  async fetchTaskStatuses({ commit }) {
    const data = await this.$axios.$get('/api/statusList');
    commit('setStatusList', data);
  },

  async fetchTaskTypes({ commit }) {
    const data = await this.$axios.$get('/api/typeList');
    commit('setTypeList', data);
  },

  async fetchTaskPriorities({ commit }) {
    const data = await this.$axios.$get('/api/priorityList');
    commit('setPriorityList', data);
  }
}
