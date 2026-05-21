import axiosInstance from "../api/axiosInstance"

const API = "/api/vouchers"

export default {
  getAll(page = 1) {
    return axiosInstance.get(`${API}?page=${page}`);
  },

  getOne(id) {
    return axiosInstance.get(`${API}/${id}`);
  },

  create(data) {
    return axiosInstance.post(API, data);
  },

  update(id, data) {
    return axiosInstance.put(`${API}/${id}`, data);
  },

  delete(id) {
    return axiosInstance.delete(`${API}/${id}`);
  }
};