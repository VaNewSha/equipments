class Api {
    static getEquipmentTypeData(token) {
        return axios.get(`/api/equipment-type`, { headers: {'authorization': `Bearer ${token}`}});
    }

    static getEquipmentData(params, token) {
        return axios.get(`/api/equipment${Api.paramsBuilder(params)}`, { headers: {'authorization': `Bearer ${token}`}});
    }

    static createEquipmentData(body, token) {
        return axios.post('/api/equipment', body, { headers: {'authorization': `Bearer ${token}`}});
    }

    static showEquipmentData(id, token) {
        return axios.get(`/api/equipment/${id}`,  { headers: {'authorization': `Bearer ${token}`}});
    }

    static updateEquipmentData(id, body, token) {
        return axios.put(`/api/equipment/${id}`, body,  { headers: {'authorization': `Bearer ${token}`}});
    }

    static deleteEquipmentData(id, token) {
        return axios.delete(`/api/equipment/${id}`,  { headers: {'authorization': `Bearer ${token}`}});
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
