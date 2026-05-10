import axios from "axios";

const API_URL = "http://127.0.0.1:8000/api/orders";

export default {
  getAll(page = 1, search = "") {
    return axios.get(`${API_URL}?page=${page}&search=${search}`);
  },

  getOne(id) {
    return axios.get(`${API_URL}/${id}`);
  },

  create(data) {
    return axios.post(API_URL, data);
  },

  update(id, data) {
    return axios.put(`${API_URL}/${id}`, data);
  },

  delete(id) {
    return axios.delete(`${API_URL}/${id}`);
  }
};