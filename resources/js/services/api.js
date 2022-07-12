class Api {
    static getEquipmentTypeData() {
        return axios.get(`/api/equipment-type`);
    }

    static getEquipmentData(params) {
        return axios.get(`/api/equipment${Api.paramsBuilder(params)}`);
    }

    static updateEquipmentData(id, body) {
        return axios.put(`/api/equipment/${id}`, body);
    }

    static deleteEquipmentData(id) {
        return axios.delete(`/api/equipment/${id}`);
    }

  static paramsBuilder(params) {
    const esc = encodeURIComponent;
    const query = Object.keys(params)
      .map((k) => `${esc(k)}=${esc(params[k])}`)
      .join('&');
    if (query !== '') {
      return `?${query}`;
    }
    return '';
  }
}

export default Api;
